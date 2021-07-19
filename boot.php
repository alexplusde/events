<?php

if (rex::isBackend() && rex_be_controller::getCurrentPage() == 'events/calendar') {
    rex_view::addJsFile($this->getAssetsUrl('fullcalendar/packages/core/main.js'));
    rex_view::addCssFile($this->getAssetsUrl('fullcalendar/packages/core/main.css'));
    rex_view::addJsFile($this->getAssetsUrl('fullcalendar/packages/daygrid/main.js'));
    rex_view::addCssFile($this->getAssetsUrl('fullcalendar/packages/daygrid/main.css'));
    rex_view::addJsFile($this->getAssetsUrl('fullcalendar/packages/bootstrap/main.js'));
    rex_view::addCssFile($this->getAssetsUrl('fullcalendar/packages/bootstrap/main.css'));
    rex_view::addJsFile($this->getAssetsUrl('fullcalendar/packages/timegrid/main.js'));
    rex_view::addCssFile($this->getAssetsUrl('fullcalendar/packages/timegrid/main.css'));
    rex_view::addJsFile($this->getAssetsUrl('fullcalendar/packages/list/main.js'));
    rex_view::addCssFile($this->getAssetsUrl('fullcalendar/packages/list/main.css'));
    rex_view::addJsFile($this->getAssetsUrl('fullcalendar/packages/core/locales/de.js'));
    rex_view::addJsFile($this->getAssetsUrl('backend.js'));
}

rex_yform_manager_dataset::setModelClass(
    'rex_event_date',
    event_date::class
);
rex_yform_manager_dataset::setModelClass(
    'rex_event_location',
    event_location::class
);
rex_yform_manager_dataset::setModelClass(
    'rex_event_category',
    event_category::class
);
rex_yform_manager_dataset::setModelClass(
    'rex_event_date_offer',
    event_date_offer::class
);

if (rex_addon::get('cronjob')->isAvailable() && !rex::isSafeMode()) {
    rex_cronjob_manager::registerType('rex_cronjob_events_ics_import');
}

if (rex_plugin::get('yform', 'rest')->isAvailable() && !rex::isSafeMode()) {

/* YForm Rest API */
    $rex_event_date_route = new \rex_yform_rest_route(
        [
        'path' => '/v0.dev/event/date/',
        'auth' => '\rex_yform_rest_auth_token::checkToken',
        'type' => \event_date::class,
        'query' => \event_date::query(),
        'get' => [
            'fields' => [
                'rex_event_date' => [
                    'id',
                    'name',
                    'description',
                    'location',
                    'image',
                    'startDate',
                    'doorTime',
                    'endDate',
                    'eventStatus',
                    'url'
                 ],
                 'rex_event_category' => [
                    'id',
                    'name',
                    'image'
                 ],
                 'rex_event_location' => [
                    'id',
                    'name',
                    'street',
                    'zip',
                    'locality',
                    'lat',
                    'lng'
                 ]
            ]
        ],
        'post' => [
            'fields' => [
                'rex_event_date' => [
                    'name',
                    'description',
                    'location',
                    'image',
                    'startDate',
                    'doorTime',
                    'endDate',
                    'eventStatus',
                ]
            ]
        ],
        'delete' => [
            'fields' => [
                'rex_event_date' => [
                    'id'
                ]
            ]
        ]
    ]
    );

    \rex_yform_rest::addRoute($rex_event_date_route);


    /* YForm Rest API */
    $rex_event_category_route = new \rex_yform_rest_route(
        [
        'path' => '/v0.dev/event/category/',
        'auth' => '\rex_yform_rest_auth_token::checkToken',
        'type' => \event_category::class,
        'query' => \event_category::query(),
        'get' => [
            'fields' => [
                 'rex_event_category' => [
                    'id',
                    'name',
                    'image'
                 ]
            ]
        ],
        'post' => [
            'fields' => [
                'rex_event_category' => [
                    'name',
                    'image'
                ]
            ]
        ],
        'delete' => [
            'fields' => [
                'rex_event_category' => [
                    'id'
                ]
            ]
        ]
    ]
    );

    \rex_yform_rest::addRoute($rex_event_category_route);

    /* YForm Rest API */
    $rex_event_location_route = new \rex_yform_rest_route(
        [
        'path' => '/v0.dev/event/location/',
        'auth' => '\rex_yform_rest_auth_token::checkToken',
        'type' => \event_location::class,
        'query' => \event_location::query(),
        'get' => [
            'fields' => [
                 'rex_event_location' => [
                    'id',
                    'name',
                    'street',
                    'zip',
                    'locality',
                    'lat',
                    'lng'
                 ]
            ]
        ],
        'post' => [
            'fields' => [
                'rex_event_location' => [
                    'name',
                    'name',
                    'street',
                    'zip',
                    'locality',
                    'lat',
                    'lng'
                ]
            ]
        ],
        'delete' => [
            'fields' => [
                'rex_event_location' => [
                    'id'
                ]
            ]
        ]
    ]
    );

    \rex_yform_rest::addRoute($rex_event_location_route);
}

rex_extension::register('REX_YFORM_SAVED', function (rex_extension_point $ep) {

    // darf nur bei passender Tabelle passieren.
//    $id = $ep->getParam('id');
//    $dataset = event_date::get($ep->getParam('id'));
//    rex_sql::factory()->setQuery("UPDATE rex_event_date SET uid = :uid WHERE id = :id", [":uid"=>$dataset->getUid(), ":id" => $id]);
});
