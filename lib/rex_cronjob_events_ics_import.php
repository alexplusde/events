<?php
use ICal\ICal;

class rex_cronjob_events_ics_import extends rex_cronjob
{
    public function execute(): bool
    {
        try {
            $ical = new ICal('ICal.ics', array(
                'defaultSpan'                 => 2,     // Default value
                'defaultTimeZone'             => 'UTC',
                'defaultWeekStart'            => 'MO',  // Default value
                'disableCharacterReplacement' => false, // Default value
                'skipRecurrence'              => false, // Default value
                'useTimeZoneWithRRules'       => false, // Default value
            ));
            $ical->initUrl($this->getParam('url'));
            $vEvents = $ical->cal['VEVENT'];
        } catch (\Exception $e) {
            $this->setMessage('ICS-Datei Konnte nicht importiert werden.');
            return false;
        }

        // Wenn die Option "default" nicht gesetzt ist, werden zusätzliche Events-Kategorien angelegt:
        if ($this->getParam('category_sync') !== 'default') {
            // ...andernfalls werden Kategorien aus der ICS-Datei in Events angelegt
            $sql = rex_sql::factory()->setDebug(0);

            // Herausfinden, welche Kategorien in Events vorkommen
            $existing_categories = $sql->getArray('SELECT id, name_'.$this->getParam('clang_id').' AS name FROM `rex_event_category`');
            $debug_dump['$existing_categories'] = $existing_categories;
            $existing_categories_names = [];
            // TODO: Hier stattdessen array_column($sql->getArray(...), 'name', 'id') verwenden?
            foreach ($existing_categories as $existing_category) {
                $existing_categories_names[] = $existing_category['name'];
            }
    
            // Herausfinden, welche Kategorien in der ICS-Datei vorkommen
            $category_names_per_event = [];
            if (count($vEvents)) {
                foreach ($vEvents as $vEvent) {
                    $category_names_per_event = array_merge($category_names_per_event, explode(",", $vEvent['CATEGORIES']));
                }
            }
            $category_names_per_event = array_unique($category_names_per_event);

            // Herausfinden, welche Kategorie-Namen noch nicht vorhanden sind
            $debug_dump['$add_categories'] = $add_categories = array_diff($category_names_per_event, $existing_categories_names);
    
            // Neue Kategorien hinzufügen
            foreach ($add_categories as $category_name) {
                $category = event_category::create('rex_event_category');

                $category->setValue('name', $category_name);
                $category->setValue('createdate', date("Y-m-d H:i:s", strtotime($vEvent['DTSTAMP'])));
                $category->setValue('updatedate', date("Y-m-d H:i:s", strtotime($vEvent['DTSTAMP'])));
                $category->setValue('createuser', "Cronjob");
                $category->setValue('updateuser', "Cronjob");

                $category->save();
            }
        }

        // Wenn Option "Remove" gesetzt ist, werden überschüssige Kategorien gelöscht
        if ($this->getParam('category_sync') === 'remove') {
            $debug_dump['$remove_categories'] = $remove_categories = array_diff($existing_categories_names, $category_names_per_event);

            foreach ($remove_categories as $remove_category) {
                $category_query = 'DELETE FROM rex_event_category WHERE name_'.$this->getParam('clang_id').' = :name';
                $debug_dump['remove_category'][] = rex_sql::factory()->setDebug(0)->setQuery($category_query, [":name" => $remove_category]);
            }
        }

        // Neue hinzugefügte Kategorien berücksichtigen
        $existing_categories = rex_sql::factory()->getArray('SELECT id, name_'.$this->getParam('clang_id').' AS name FROM `rex_event_category`');
        $debug_dump['$existing_categories new'] = $existing_categories;

        // aktuelle Locations herausfinden
        $existing_locations = rex_sql::factory()->getArray('SELECT id, name_'.$this->getParam('clang_id').' AS name FROM `rex_event_location`');
        $debug_dump['$existing_locations'] = $existing_locations;

        // TODO: Gleiche Überprüfung der Locations wie mit Kategorien + Parsen der Adresse
        if (count($vEvents)) {
            $debug_dump['$vEvents'] = $vEvents;
            foreach ($vEvents as $vEvent) {
                $category_ids = [];
                if ($this->getParam('category_sync') === 'default') {
                    $category_ids[] = $this->getParam('category_id');
                } else {
                    foreach ($existing_categories as $existing_category) {
                        if ($id = array_search($existing_category['name'], explode(",", $vEvent['CATEGORIES']))) {
                            $category_ids[] = $id;
                        }
                    }
                }

                $location_id = 0;
                if ($this->getParam('location_id')) {
                    $location_id = $this->getParam('location_id');
                } else {
                    // TODO: Location ausfindig machen und ggf. geocodieren, neue Locations eintragen.
                }


                $category_ids = array_unique($category_ids);

                $event_date = event_date::create();

                $event_date->setValue('start_date', date("Y-m-d", strtotime($vEvent['DTSTART'])));
                $event_date->setValue('end_date', date("Y-m-d", strtotime($vEvent['DTEND'])));
                // wenn fulltime Abkehr von ics-Konvention weil Events diese als mehrtägig darstellt.
                $event_date->setValue('is_fulltime', (int)!(bool)(strtotime($vEvent['DTEND']) - strtotime($vEvent['DTSTART'] ."+ 1 DAY")));
                $event_date->setValue('start_time', date("H:i:s", strtotime($vEvent['DTSTART'])));
                $event_date->setValue('end_time', date("H:i:s", strtotime($vEvent['DTEND'])));
                $event_date->setValue('category', implode(",", $category_ids));
                $event_date->setValue('venue', $location_id);
                $event_date->setValue('status', 1); // TODO: Status zuordnen. CONFIRMED? Abgesagt?
                $event_date->setValue('name', $vEvent['SUMMARY']);
                $event_date->setValue('text', $vEvent['DESCRIPTION'] ?? "");
                $event_date->setValue('createdate', date("Y-m-d H:i:s", strtotime($vEvent['DTSTAMP']))); // TODO: Ist es wirklich immer DTSTAMP? Ist die Uhrzeit korrekt?
                $event_date->setValue('updatedate', date("Y-m-d H:i:s", strtotime($vEvent['DTSTAMP'])));
                $event_date->setValue('createuser', "Cronjob");
                $event_date->setValue('updateuser', "Cronjob");
                $event_date->setValue('uid', $vEvent['UID']);
                $event_date->setValue('raw', json_encode($vEvent));
                $event_date->setValue('source_url', $this->getParam('url'));

                // Wenn wiederkehrender Termin die rrules auslesen
                if (!array_key_exists('RRULE', $vEvent)) {
                    //default once
                    $event_date->setValue('type', 'one_time');
                    $event_date->setValue('repeat', null);
                    $event_date->setValue('repeat_year', null);
                    $event_date->setValue('repeat_week', null);
                    $event_date->setValue('repeat_month', null);
                    $event_date->setValue('end_repeat_date', null);
                } else {
                    // repeating
                    $rrules = [];
                    // Explode RRULE into assoc array, e.g. from FREQ=WEEKLY;BYDAY=FR;UNTIL=20191102T000000
                    foreach (explode(";", $vEvent['RRULE']) as $rrule_parm) {
                        list($cKey, $cValue) = explode('=', $rrule_parm, 2);
                        $rrules[$cKey] = $cValue;
                    }
                    $dataset->setValue('type', 'repeat');
                    $dataset->setValue('repeat', strtolower($rrules['FREQ']));
                    $dataset->setValue('repeat_year', 1);
                    $dataset->setValue('repeat_week', 1);
                    $dataset->setValue('repeat_month', 1);
                    $dataset->setValue('end_repeat_date', date("Y-m-d", strtotime($rrules['UNTIL'])));
                }

                $error_counter = 0;
                $success_counter = 0;

                try {
                    $event_date->save();
                    $success_counter++;
                } catch (rex_sql_exception $e) {
                    $error_counter++;
                };
            }
        }
        $this->setMessage((int)$success_counter.' Datensätze importiert / aktualisiert, '.(int)$error_counter.' Fehler.'); // TODO: Meldung übersetzen und Parameter als Platzhalter einfügen

        if ($error_counter) {
            return false;
        } else {
            return true;
        }
    }

    public function getTypeName(): string
    {
        return rex_i18n::msg('events_ics_import_cronjob_name');
    }

    public function getParamFields(): array
    {
        // ICS-Datei als Demo vorschlagen
        $default_url = 'https://www.schulferien.org/deutschland/ical/download/?lid=81&j='.date("Y").'&t=2';
        
        // Auswahl für REDAXO-Sprachen zusammenzustellen
        $clangs = rex_clang::getAll();
        $clang_ids = [];
        foreach ($clangs as $clang) {
            $clang_ids[$clang->getValue('id')] = $clang->getValue('name');
        }

        // Benutzerdefinierte Standard-Kategorie auswählen
        $sql_categories = rex_sql::factory()->setDebug(0)->getArray('SELECT id, name AS name FROM `rex_event_category`');

        $events_category_ids = [];
        $events_category_ids[0] = rex_i18n::msg('events_ics_import_cronjob_choose');

        foreach ($sql_categories as $sql_category) {
            $events_category_ids[$sql_category['id']] = $sql_category['name'];
        }
        
        // Benutzerdefinierte Standard-Location auswählen
        $sql_locations = rex_sql::factory()->setDebug(0)->getArray('SELECT id, name AS name FROM `rex_event_location`');
        $events_location_ids = [];
        $events_location_ids[0] = rex_i18n::msg('events_ics_import_cronjob_choose_none');

        foreach ($sql_locations as $sql_location) {
            $events_location_ids[$sql_location['id']] = $sql_location['name'];
        }

        // Eingabefelder des Cronjobs definieren
        $fields = [
            [
                'label' => rex_i18n::msg('events_ics_import_cronjob_url_label'),
                'name' => 'url',
                'type' => 'text',
                'default' => $default_url,
                'notice' => rex_i18n::msg('events_ics_import_cronjob_url_notice'),
            ],
            [
                'name' => 'category_sync',
                'label' => 'Kategorie-Optionen',
                'type' => 'select',
                'default' => 'keep',
                'options' => ['remove' => rex_i18n::msg('events_ics_import_cronjob_category_remove'),
                              'default' => rex_i18n::msg('events_ics_import_cronjob_category_default_id'),
                              'keep' => rex_i18n::msg('events_ics_import_cronjob_category_keep')],
                'notice' => rex_i18n::msg('events_ics_import_cronjob_category_sync')
            ],
            [
                'name' => 'category_id',
                'type' => 'select',
                'default' => $sql_categories[0]['id'],
                'options' => $events_category_ids,
                'notice' => rex_i18n::msg('events_ics_import_cronjob_default_category_sync_id_notice')
            ],
            [
                'name' => 'location_id',
                'type' => 'select',
                'label' => 'Standard-Location',
                'default' => $sql_locations[0]['id'],
                'options' => $events_location_ids,
                'notice' => rex_i18n::msg('events_ics_import_cronjob_default_location_sync_id_notice')
            ],
            [
                'name' => 'clang_id',
                'type' => 'select',
                'label' => 'Sprache',
                'default' => rex_clang::getCurrentId(),
                'options' => $clang_ids,
                'notice' => rex_i18n::msg('events_ics_import_cronjob_clang_id_notice')
            ],
            [
                'name' => 'geocoding',
                'type' => 'checkbox',
                'default' => 0,
                'options' => [1 => rex_i18n::msg('events_ics_import_cronjob_geocoding')], // TODO: Geocodierung umsetzen
                'notice' => rex_i18n::msg('events_ics_import_cronjob_geocoding_notice')
            ],
            [
                'name' => 'debug',
                'type' => 'checkbox',
                'default' => 0,
                'options' => [1 => rex_i18n::msg('events_ics_import_cronjob_debug')],
                'notice' => rex_i18n::msg('events_ics_import_cronjob_debug_notice')
            ]
        ];

        return $fields;
    }
}
