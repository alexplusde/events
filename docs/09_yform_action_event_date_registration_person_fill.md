# YForm Action `event_date_registration_person_fill`

Die Klasse `rex_yform_action_event_date_registration_person_fill` erweitert YForm um eine Aktion,
die es erleichtert, Teilnehmerlisten und Anmeldungen mit mehreren Personen zu erfassen,
wenn eine Registrierung mehr als eine Person beinhaltet.

Sie erbt von der `rex_yform_action_abstract` Klasse und bietet zusätzliche Methoden
zur Interaktion mit den Anmeldungen eines Event-Datums.

Als Wert, wie häufig eine Anmeldung ausgeführt werden soll, wird die Anzahl der Personen im Feld `person_count` erwartet.

## Pipe-Schreibweise

```text
action|event_date_registration_person_fill
```

## PHP-Schreibweise

```php
$yform->setActionField('event_date_registration_person_fill', []);
```
