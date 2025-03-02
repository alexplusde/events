<?php

rex_sql_table::get(rex::getTable('event_date'))
    ->ensurePrimaryIdColumn()
    ->ensureColumn(new rex_sql_column('name', 'varchar(191)', false, ''))
    ->ensureColumn(new rex_sql_column('teaser', 'text'))
    ->ensureColumn(new rex_sql_column('description', 'text'))
    ->ensureColumn(new rex_sql_column('lang_id', 'int(11)'))
    ->ensureColumn(new rex_sql_column('event_category_id', 'varchar(191)'))
    ->ensureColumn(new rex_sql_column('category_id', 'varchar(191)'))
    ->ensureColumn(new rex_sql_column('startDate', 'date'))
    ->ensureColumn(new rex_sql_column('all_day', 'tinyint(1)', false, '0'))
    ->ensureColumn(new rex_sql_column('doorTime', 'time'))
    ->ensureColumn(new rex_sql_column('startTime', 'time'))
    ->ensureColumn(new rex_sql_column('endTime', 'time'))
    ->ensureColumn(new rex_sql_column('endDate', 'date'))
    ->ensureColumn(new rex_sql_column('location', 'int(10) unsigned'))
    ->ensureColumn(new rex_sql_column('space', 'decimal(3,0)', true))
    ->ensureColumn(new rex_sql_column('image_poster', 'text'))
    ->ensureColumn(new rex_sql_column('image', 'text'))
    ->ensureColumn(new rex_sql_column('images', 'text'))
    ->ensureColumn(new rex_sql_column('url', 'varchar(191)', false, ''))
    ->ensureColumn(new rex_sql_column('video_url', 'varchar(191)', false, ''))
    ->ensureColumn(new rex_sql_column('eventStatus', 'varchar(191)'))
    ->ensureColumn(new rex_sql_column('createuser', 'varchar(191)'))
    ->ensureColumn(new rex_sql_column('createdate', 'datetime'))
    ->ensureColumn(new rex_sql_column('updateuser', 'varchar(191)'))
    ->ensureColumn(new rex_sql_column('updatedate', 'datetime'))
    ->ensureColumn(new rex_sql_column('startDateTime', 'varchar(191)'))
    ->ensureColumn(new rex_sql_column('uid', 'varchar(36)'))
    ->ensureColumn(new rex_sql_column('uuid', 'varchar(36)'))
    ->ensureColumn(new rex_sql_column('frontend_url', 'varchar(191)'))
    ->ensureColumn(new rex_sql_column('team_id', 'text'))
    ->ensureIndex(new rex_sql_index('startDateTime', ['startDateTime']))
    ->ensureIndex(new rex_sql_index('name', ['name']))
    ->ensureIndex(new rex_sql_index('eventStatus', ['eventStatus']))
    ->ensure();

rex_sql_table::get(rex::getTable('event_date_lang'))
    ->ensurePrimaryIdColumn()
    ->ensureColumn(new rex_sql_column('name', 'varchar(191)', false, 'Deutsch'))
    ->ensureColumn(new rex_sql_column('code', 'varchar(191)', false, 'de'))
    ->ensure();


rex_sql_table::get(rex::getTable('event_date_offer'))
    ->ensurePrimaryIdColumn()
    ->ensureColumn(new rex_sql_column('date_id', 'int(10) unsigned'))
    ->ensureColumn(new rex_sql_column('url', 'varchar(191)', false, ''))
    ->ensureColumn(new rex_sql_column('price', 'varchar(191)', false, '0'))
    ->ensureColumn(new rex_sql_column('availability', 'text'))
    ->ensureColumn(new rex_sql_column('uuid', 'varchar(36)'))
    ->ensureIndex(new rex_sql_index('uuid', ['uuid'], rex_sql_index::UNIQUE))
    ->ensure();

rex_sql_table::get(rex::getTable('event_date_offer'))
    ->removeIndex('uid');


rex_sql_table::get(rex::getTable('event_date_registration'))
    ->ensurePrimaryIdColumn()
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
    ->ensureColumn(new rex_sql_column('payment', 'text'))
    ->ensureColumn(new rex_sql_column('message', 'text'))
    ->ensureColumn(new rex_sql_column('newsletter', 'tinyint(1)', false, '0'))
    ->ensureColumn(new rex_sql_column('dsgvo', 'tinyint(1)', false, '0'))
    ->ensureColumn(new rex_sql_column('agb', 'tinyint(1)', false, '0'))
    ->ensureColumn(new rex_sql_column('channel', 'varchar(191)'))
    ->ensureColumn(new rex_sql_column('price', 'varchar(191)', false, ''))
    ->ensureColumn(new rex_sql_column('status', 'varchar(191)'))
    ->ensureColumn(new rex_sql_column('deletedate', 'datetime'))
    ->ensureColumn(new rex_sql_column('uuid', 'varchar(36)'))
    ->ensureColumn(new rex_sql_column('hash', 'varchar(191)'))
    ->ensureColumn(new rex_sql_column('createdate', 'datetime'))
    ->ensureIndex(new rex_sql_index('uuid', ['uuid'], rex_sql_index::UNIQUE))
    ->ensureIndex(new rex_sql_index('hash', ['hash'], rex_sql_index::UNIQUE))
    ->ensureIndex(new rex_sql_index('email', ['email']))
    ->ensureIndex(new rex_sql_index('lastname', ['lastname']))
    ->ensure();


rex_sql_table::get(rex::getTable('event_date_registration_person'))
    ->ensurePrimaryIdColumn()
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
    ->ensureColumn(new rex_sql_column('hash', 'varchar(191)'))
    ->ensureIndex(new rex_sql_index('uuid', ['uuid'], rex_sql_index::UNIQUE))
    ->ensureIndex(new rex_sql_index('hash', ['hash'], rex_sql_index::UNIQUE))
    ->ensureIndex(new rex_sql_index('email', ['email']))
    ->ensure();

rex_sql_table::get(rex::getTable('event_location'))
    ->ensurePrimaryIdColumn()
    ->ensureColumn(new rex_sql_column('google_places', 'text', false, '\'\''))
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
    ->ensureColumn(new rex_sql_column('uuid', 'varchar(36)'))
    ->ensure();

rex_sql_table::get(rex::getTable('event_category'))
    ->ensurePrimaryIdColumn()
    ->ensureColumn(new rex_sql_column('prio', 'int(11)'))
    ->ensureColumn(new rex_sql_column('name_short', 'varchar(191)', false, ''))
    ->ensureColumn(new rex_sql_column('name', 'varchar(191)', false, ''))
    ->ensureColumn(new rex_sql_column('icon', 'varchar(191)', false, ''))
    ->ensureColumn(new rex_sql_column('teaser', 'text'))
    ->ensureColumn(new rex_sql_column('description', 'text'))
    ->ensureColumn(new rex_sql_column('images', 'text'))
    ->ensureColumn(new rex_sql_column('status', 'tinyint(1)'))
    ->ensureColumn(new rex_sql_column('image', 'text'))
    ->ensureColumn(new rex_sql_column('date_ids', 'varchar(191)'))
    ->ensureColumn(new rex_sql_column('createdate', 'datetime'))
    ->ensureColumn(new rex_sql_column('createuser', 'varchar(191)'))
    ->ensureColumn(new rex_sql_column('updatedate', 'datetime'))
    ->ensureColumn(new rex_sql_column('updateuser', 'varchar(191)'))
    ->ensureColumn(new rex_sql_column('url', 'varchar(191)'))
    ->ensureColumn(new rex_sql_column('uuid', 'varchar(36)'))
    ->ensureIndex(new rex_sql_index('name', ['name'], rex_sql_index::UNIQUE))
    ->ensureIndex(new rex_sql_index('status', ['status']))
    ->ensure();


rex_sql_table::get(rex::getTable('event_category_request'))
    ->ensurePrimaryIdColumn()
    ->ensureColumn(new rex_sql_column('status', 'varchar(191)'))
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
    ->ensureColumn(new rex_sql_column('payment', 'text'))
    ->ensureColumn(new rex_sql_column('message', 'text'))
    ->ensureColumn(new rex_sql_column('newsletter', 'tinyint(1)', false, '0'))
    ->ensureColumn(new rex_sql_column('dsgvo', 'tinyint(1)', false, '0'))
    ->ensureColumn(new rex_sql_column('agb', 'tinyint(1)', false, '0'))
    ->ensureColumn(new rex_sql_column('channel', 'text'))
    ->ensureColumn(new rex_sql_column('createdate', 'datetime'))
    ->ensureColumn(new rex_sql_column('deletedate', 'datetime'))
    ->ensureColumn(new rex_sql_column('price', 'varchar(191)', false, ''))
    ->ensureColumn(new rex_sql_column('uuid', 'varchar(36)'))
    ->ensureIndex(new rex_sql_index('uuid', ['uuid'], rex_sql_index::UNIQUE))
    ->ensureIndex(new rex_sql_index('email', ['email']))
    ->ensure();

@rex_sql::factory()->setQuery('update rex_event_date set uuid = uuid() where uuid =""');

// Prüfe, ob Feld uid existierte
if (rex_sql_table::get(rex::getTable('event_date'))->hasColumn('uid')) {

    try {
        @rex_sql::factory()->setQuery('update rex_event_date set uuid = uid() where uid != "" and uuid = ""');
        @rex_sql::factory()->setQuery('update rex_event_date set category_id = event_category_id');
    
        rex_sql_table::get(rex::getTable('event_date'))
        ->removeIndex('uid');
    
        rex_sql_table::get(rex::getTable('event_date'))
            ->removeColumn('uid')
            ->removeColumn('event_category_id')
            ->ensure();
    } catch (rex_sql_exception $e) {
        // $e->getMessage();
    }
}

rex_sql_table::get(rex::getTable('event_date'))
->ensurePrimaryIdColumn()
->ensureIndex(new rex_sql_index('uuid', ['uuid'], rex_sql_index::UNIQUE))
->ensure();
