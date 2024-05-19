# RESTful API (dev)

Die [Rest-API](https://github.com/yakamara/redaxo_yform/blob/master/docs/plugins.md#restful-api-einf%C3%BChrung) ist über das REST-Plugin von YForm umgesetzt.

## Einrichtung

Zunächst das REST-Plugin von YForm installieren und einen Token einrichten. Den Token auf die jeweiligen Endpunkte legen:

```php
    /v5.0/event/date
    /v5.0/event/category
    /v5.0/event/location
```

## Endpunkt `date`

**Auslesen:** GET `example.org/rest/v5.0/event/date/?token=###TOKEN###`

**Auslesen einzelner Termin**  GET `example.org/rest/v0.dev/event/date/7/?token=###TOKEN###` Termin  der `id=7`

## Endpunkt `category`

**Auslesen:** GET `example.org/rest/v5.0/event/category/?token=###TOKEN###`

**Auslesen einzelne Kategorie**  GET `example.org/rest/v0.dev/event/category/7/?token=###TOKEN###` Termin  der `id=7`

## Endpunkt `location`

**Auslesen:** GET `example.org/rest/v5.0/event/location/?token=###TOKEN###`

**Auslesen einzelner Standort**  GET `example.org/rest/v0.dev/event/location/7/?token=###TOKEN###` Termin  der `id=7`
