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
