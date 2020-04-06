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
