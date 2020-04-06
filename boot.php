<?php

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

if (rex_addon::get('cronjob')->isAvailable() && !rex::isSafeMode()) {
    rex_cronjob_manager::registerType('rex_cronjob_events_ics_import');
}

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
                    'offers_url',
                    'offers_price',
                    'offers_availability',
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
                    'offers_url',
                    'offers_price',
                    'offers_availability',
                    'url'
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
