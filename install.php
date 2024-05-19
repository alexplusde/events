<?php
/* Tablesets aktualisieren */
if (rex_addon::get('yform') && rex_addon::get('yform')->isAvailable()) {
    rex_yform_manager_table_api::importTablesets(rex_file::get(__DIR__ . '/install/rex_event.tableset.json'));
    rex_yform_manager_table::deleteCache();
}

if (!rex_media::get('events_fallback_image.jpg')) {
    rex_file::copy(__DIR__ . '/install/events_fallback_image.jpg', rex_path::media('events_fallback_image.jpg'));
    $data = [];
    $data['title'] = 'Termine - Fallback-Poster';
    $data['category_id'] = 0;
    $data['file'] = [
        'name' => 'events_fallback_image.jpg',
        'path' => rex_path::media('events_fallback_image.jpg'),
    ];

    rex_media_service::addMedia($data, false);
}

/* URL-Profile installieren */
/*
if (rex_addon::get('url') && rex_addon::get('url')->isAvailable()) {
    if (false === rex_config::get('events', 'url_profile', false)) {
        $rex_events_category = array_filter(rex_sql::factory()->getArray("SELECT * FROM rex_url_generator_profile WHERE `table_name` = '1_xxx_rex_events_category'"));
        if (!$rex_events_category) {
            $query = rex_file::get(__DIR__ . '/install/rex_url_profile_events_category.sql');
            rex_sql::factory()->setQuery($query);
        }
        $rex_events_entry = array_filter(rex_sql::factory()->getArray("SELECT * FROM rex_url_generator_profile WHERE `table_name` = '1_xxx_rex_events_entry'"));
        if (!$rex_events_entry) {
            $query = rex_file::get(__DIR__ . 'install/rex_url_profile_events_date.sql');
            rex_sql::factory()->setQuery($query);
        }
        /* URL-Profile wurden bereits einmal installiert, daher nicht nochmals installieren und Entwickler-Einstellungen respektieren */
/*        rex_config::set('events', 'url_profile', true);
    }
}*/


$modules = scandir(rex_path::addon("events")."module");

foreach ($modules as $module) {
    if ($module == "." || $module == "..") {
        continue;
    }
    $module_array = json_decode(rex_file::get(rex_path::addon("events")."module/".$module), 1);

    rex_sql::factory()->setDebug(0)->setTable("rex_module")
    ->setValue("name", $module_array['name'])
    ->setValue("key", $module_array['key'])
    ->setValue("input", $module_array['input'])
    ->setValue("output", $module_array['output'])
    ->setValue("createuser", "")
    ->setValue("updateuser", "events")
    ->setValue("createdate", date("Y-m-d H:i:s"))
    ->setValue("updatedate", date("Y-m-d H:i:s"))
    ->insertOrUpdate();
}

/* Indizes sicherstellen */

rex_sql_table::get(rex::getTable('event_category'))
->ensurePrimaryIdColumn()
/*
->ensureColumn(new rex_sql_column('prio', 'int(11)'))
->ensureColumn(new rex_sql_column('name', 'varchar(191)', false, ''))
->ensureColumn(new rex_sql_column('icon', 'varchar(191)', false, ''))
->ensureColumn(new rex_sql_column('teaser', 'text'))
->ensureColumn(new rex_sql_column('description', 'text'))
->ensureColumn(new rex_sql_column('images', 'text'))
->ensureColumn(new rex_sql_column('status', 'tinyint(1)'))
->ensureColumn(new rex_sql_column('createuser', 'varchar(191)'))
->ensureColumn(new rex_sql_column('updateuser', 'varchar(191)'))
*/
->ensureIndex(new rex_sql_index('name', ['name'], rex_sql_index::UNIQUE))
->ensureIndex(new rex_sql_index('status', ['status']))
->ensure();

rex_sql_table::get(rex::getTable('event_category_request'))
->ensurePrimaryIdColumn()
/*
->ensureColumn(new rex_sql_column('status', 'text'))
->ensureColumn(new rex_sql_column('category_id', 'int(10) unsigned'))
->ensureColumn(new rex_sql_column('date', 'varchar(191)', false, ''))
->ensureColumn(new rex_sql_column('category', 'varchar(191)', false, ''))
->ensureColumn(new rex_sql_column('salutation', 'varchar(191)', false, ''))
->ensureColumn(new rex_sql_column('firstname', 'varchar(191)', false, ''))
->ensureColumn(new rex_sql_column('lastname', 'varchar(191)', false, ''))
->ensureColumn(new rex_sql_column('email', 'varchar(191)', false, 'Bitte geben Sie eine E‑Mail-Adresse an, über die wir Sie zu denen von Ihnen ausgewählten Kursen informieren können.'))
->ensureColumn(new rex_sql_column('street', 'varchar(191)', false, ''))
->ensureColumn(new rex_sql_column('zip', 'varchar(191)', false, ''))
->ensureColumn(new rex_sql_column('city', 'varchar(191)', false, ''))
->ensureColumn(new rex_sql_column('phone', 'varchar(191)', false, ''))
->ensureColumn(new rex_sql_column('birthday', 'varchar(191)', false, ''))
->ensureColumn(new rex_sql_column('person_count', 'decimal(2,0)', true))
->ensureColumn(new rex_sql_column('message', 'text'))
->ensureColumn(new rex_sql_column('newsletter', 'tinyint(1)', false, '0'))
->ensureColumn(new rex_sql_column('dsgvo', 'tinyint(1)', false, '0'))
->ensureColumn(new rex_sql_column('agb', 'tinyint(1)', false, '0'))
->ensureColumn(new rex_sql_column('channel', 'text'))
->ensureColumn(new rex_sql_column('createdate', 'datetime'))
->ensureColumn(new rex_sql_column('deletedate', 'datetime'))
->ensureColumn(new rex_sql_column('uuid', 'varchar(36)'))
*/
->ensureIndex(new rex_sql_index('uuid', ['uuid'], rex_sql_index::UNIQUE))
->ensureIndex(new rex_sql_index('email', ['email']))
->ensure();

rex_sql_table::get(rex::getTable('event_date'))
->ensurePrimaryIdColumn()
/*
->ensureColumn(new rex_sql_column('name', 'varchar(191)', false, ''))
->ensureColumn(new rex_sql_column('teaser', 'text'))
->ensureColumn(new rex_sql_column('description', 'text'))
->ensureColumn(new rex_sql_column('lang_id', 'int(11)'))
->ensureColumn(new rex_sql_column('event_category_id', 'varchar(191)'))
->ensureColumn(new rex_sql_column('startDate', 'date'))
->ensureColumn(new rex_sql_column('all_day', 'tinyint(1)', false, '0'))
->ensureColumn(new rex_sql_column('doorTime', 'time'))
->ensureColumn(new rex_sql_column('startTime', 'time'))
->ensureColumn(new rex_sql_column('endTime', 'time'))
->ensureColumn(new rex_sql_column('endDate', 'date'))
->ensureColumn(new rex_sql_column('location', 'int(10) unsigned'))
->ensureColumn(new rex_sql_column('space', 'decimal(3,0)', true))
->ensureColumn(new rex_sql_column('image_poster', 'text'))
->ensureColumn(new rex_sql_column('images', 'text'))
->ensureColumn(new rex_sql_column('url', 'varchar(191)', false, ''))
->ensureColumn(new rex_sql_column('video_url', 'varchar(191)', false, ''))
->ensureColumn(new rex_sql_column('eventStatus', 'varchar(191)'))
->ensureColumn(new rex_sql_column('createuser', 'varchar(191)'))
->ensureColumn(new rex_sql_column('createdate', 'datetime'))
->ensureColumn(new rex_sql_column('updateuser', 'varchar(191)'))
->ensureColumn(new rex_sql_column('updatedate', 'datetime'))
->ensureColumn(new rex_sql_column('uid', 'varchar(191)', false, ''))
->ensureColumn(new rex_sql_column('startDateTime', 'varchar(191)'))
*/
->ensureIndex(new rex_sql_index('uid', ['uid'], rex_sql_index::UNIQUE))
->ensureIndex(new rex_sql_index('startDateTime', ['startDateTime']))
->ensureIndex(new rex_sql_index('name', ['name']))
->ensureIndex(new rex_sql_index('eventStatus', ['eventStatus']))
->ensure();

rex_sql_table::get(rex::getTable('event_date_lang'))
->ensurePrimaryIdColumn()
/*
->ensureColumn(new rex_sql_column('name', 'varchar(191)', false, 'Deutsch'))
->ensureColumn(new rex_sql_column('code', 'varchar(191)', false, 'de'))
*/
->ensure();

rex_sql_table::get(rex::getTable('event_date_offer'))
->ensurePrimaryIdColumn()
/*
->ensureColumn(new rex_sql_column('date_id', 'text'))
->ensureColumn(new rex_sql_column('url', 'varchar(191)', false, ''))
->ensureColumn(new rex_sql_column('price', 'varchar(191)', false, '0'))
->ensureColumn(new rex_sql_column('availability', 'text'))
->ensureColumn(new rex_sql_column('uid', 'varchar(191)', false, ''))
*/
->ensureIndex(new rex_sql_index('uid', ['uid'], rex_sql_index::UNIQUE))
->ensure();

rex_sql_table::get(rex::getTable('event_date_registration'))
->ensurePrimaryIdColumn()
/*
->ensureColumn(new rex_sql_column('category_id', 'int(10) unsigned'))
->ensureColumn(new rex_sql_column('date_id', 'int(10) unsigned'))
->ensureColumn(new rex_sql_column('event_location_id', 'int(10) unsigned'))
->ensureColumn(new rex_sql_column('date', 'varchar(191)', false, ''))
->ensureColumn(new rex_sql_column('category', 'varchar(191)', false, ''))
->ensureColumn(new rex_sql_column('salutation', 'varchar(191)', false, ''))
->ensureColumn(new rex_sql_column('firstname', 'varchar(191)', false, ''))
->ensureColumn(new rex_sql_column('lastname', 'varchar(191)', false, ''))
->ensureColumn(new rex_sql_column('email', 'varchar(191)', false, 'Bitte geben Sie eine E‑Mail-Adresse an, über die wir Sie zu denen von Ihnen ausgewählten Kursen informieren können.'))
->ensureColumn(new rex_sql_column('street', 'varchar(191)', false, ''))
->ensureColumn(new rex_sql_column('zip', 'varchar(191)', false, ''))
->ensureColumn(new rex_sql_column('city', 'varchar(191)', false, ''))
->ensureColumn(new rex_sql_column('phone', 'varchar(191)', false, ''))
->ensureColumn(new rex_sql_column('birthday', 'varchar(191)', false, ''))
->ensureColumn(new rex_sql_column('person_count', 'decimal(2,0)', true))
->ensureColumn(new rex_sql_column('message', 'text'))
->ensureColumn(new rex_sql_column('newsletter', 'tinyint(1)', false, '0'))
->ensureColumn(new rex_sql_column('dsgvo', 'tinyint(1)', false, '0'))
->ensureColumn(new rex_sql_column('agb', 'tinyint(1)', false, '0'))
->ensureColumn(new rex_sql_column('channel', 'text'))
->ensureColumn(new rex_sql_column('price', 'varchar(191)', false, ''))
->ensureColumn(new rex_sql_column('status', 'text'))
->ensureColumn(new rex_sql_column('deletedate', 'datetime'))
->ensureColumn(new rex_sql_column('uuid', 'varchar(36)'))
->ensureColumn(new rex_sql_column('hash', 'varchar(191)'))
->ensureColumn(new rex_sql_column('createdate', 'datetime'))
*/
->ensureIndex(new rex_sql_index('uuid', ['uuid'], rex_sql_index::UNIQUE))
->ensureIndex(new rex_sql_index('hash', ['hash'], rex_sql_index::UNIQUE))
->ensureIndex(new rex_sql_index('email', ['email']))
->ensureIndex(new rex_sql_index('lastname', ['lastname']))
->ensure();

rex_sql_table::get(rex::getTable('event_date_registration_person'))
->ensurePrimaryIdColumn()
/*
->ensureColumn(new rex_sql_column('event_date_id', 'int(10) unsigned'))
->ensureColumn(new rex_sql_column('registration_id', 'int(10) unsigned'))
->ensureColumn(new rex_sql_column('firstname', 'varchar(191)', false, ''))
->ensureColumn(new rex_sql_column('lastname', 'varchar(191)', false, ''))
->ensureColumn(new rex_sql_column('birthday', 'date'))
->ensureColumn(new rex_sql_column('email', 'varchar(191)', false, ''))
->ensureColumn(new rex_sql_column('phone', 'varchar(191)', false, ''))
->ensureColumn(new rex_sql_column('status', 'int(11)'))
->ensureColumn(new rex_sql_column('createdate', 'datetime'))
->ensureColumn(new rex_sql_column('updatedate', 'datetime'))
->ensureColumn(new rex_sql_column('deletedate', 'datetime'))
->ensureColumn(new rex_sql_column('uuid', 'varchar(36)'))
->ensureColumn(new rex_sql_column('hash', 'text'))
*/
->ensureIndex(new rex_sql_index('uuid', ['uuid'], rex_sql_index::UNIQUE))
->ensureIndex(new rex_sql_index('hash', ['hash'], rex_sql_index::UNIQUE))
->ensureIndex(new rex_sql_index('email', ['email']))
->ensure();
rex_sql_table::get(rex::getTable('event_location'))
->ensurePrimaryIdColumn()
/*
->ensureColumn(new rex_sql_column('google_places', 'text'))
->ensureColumn(new rex_sql_column('location_category_id', 'int(10) unsigned'))
->ensureColumn(new rex_sql_column('name', 'varchar(191)', false, ''))
->ensureColumn(new rex_sql_column('street', 'varchar(191)', false, ''))
->ensureColumn(new rex_sql_column('zip', 'varchar(191)', false, ''))
->ensureColumn(new rex_sql_column('locality', 'varchar(191)', false, ''))
->ensureColumn(new rex_sql_column('countrycode', 'text'))
->ensureColumn(new rex_sql_column('lat', 'varchar(191)', false, ''))
->ensureColumn(new rex_sql_column('lng', 'varchar(191)', false, ''))
->ensureColumn(new rex_sql_column('lat_lng', 'text'))
->ensureColumn(new rex_sql_column('updateuser', 'varchar(191)'))
->ensureColumn(new rex_sql_column('createuser', 'varchar(191)'))
->ensureColumn(new rex_sql_column('updatedate', 'datetime'))
->ensureColumn(new rex_sql_column('createdate', 'datetime'))
*/
->ensure();
