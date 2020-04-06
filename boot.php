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


/* YForm Rest API */
$rex_event_date_route = new \rex_yform_rest_route(
    [
        'path' => '/v0.1/event/date/',
        'auth' => '\rex_yform_rest_auth_token::checkToken',
        'type' => \event_date::class,
        'query' => \event_date::query(),
        'get' => [
            'fields' => [
                'rex_event_date' => [
                    'id',
                    'name',
                    'url'
                 ],
                 'rex_event_location' => [
                    'id',
                    'name'
                 ]
            ]
        ],
        'post' => [
            'fields' => [
                'rex_event_date' => [
                    'name',
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

// Einbinden der Konfiguration
\rex_yform_rest::addRoute($route);
