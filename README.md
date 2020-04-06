# Terminverwaltung für REDAXO 5.10 & YForm 3.3

Mit diesem Addon können Termine anhand von YForm und YOrm im Backend verwaltet und im Frontend ausgegeben werden.

## Features

* Vollständig mit **YForm** umgesetzt: Alle Features und Anpassungsmöglichkeiten von YForm verfügbar
* Einfach: Die Ausgabe erfolgt über [`rex_sql`](https://redaxo.org/doku/master/datenbank-queries) oder objektorientiert über [YOrm](https://github.com/yakamara/redaxo_yform_docs/blob/master/de_de/yorm.md)
* Flexibel: **Zugriff** über die [YForm Rest-API](https://github.com/yakamara/redaxo_yform/blob/master/docs/plugins.md#restful-api-einf%C3%BChrung)
* Sinnvoll: Nur ausgewählte **Rollen**/Redakteure haben Zugriff
* Bereit für mehr: Vorbereitet für das [JSON+LD-Format](https://jsonld.com/event/), ICS-Format


> **Tipp:** Events arbeitet hervorragend zusammen mit den Addons [`yform_usability`](https://github.com/FriendsOfREDAXO/yform_usability/) und [`yform_geo_osm`](https://github.com/FriendsOfREDAXO/yform_geo_osm)

> **Steuere eigene Verbesserungen** dem [GitHub-Repository von events](https://github.com/alexplusde/events) bei. Oder **unterstütze dieses Addon:** Mit einer [Spende oder Beauftragung unterstützt du die Weiterentwicklung dieses AddOns](https://github.com/sponsors/alexplusde)

## Installation

Im REDAXO-Installer das Addon `events` herunterladen und installieren. Anschließend erscheint ein neuer Menüpunkt `Veranstaltungen` sichtbar.

## Nutzung im Backend: Die Terminverwaltung

### Die Tabelle "TERMINE"

In der Termin-Tabelle werden einzelne Daten festgehalten. Nach der Installation von `events` stehen folgende Felder zur Verfügung:

| Typ      | Typname             | Name                | Bezeichnung       |
|----------|---------------------|---------------------|-------------------|
| value    | text                | name                | Name              |
| validate | empty               | name                |                   |
| value    | textarea            | description         | Beschreibung      |
| value    | be_manager_relation | event_category_id   | Kategorie         |
| value    | be_manager_relation | location            | Veranstaltungsort |
| value    | be_media            | image               | Bild              |
| value    | text                | url                 | URL               |
| value    | datetime            | startDate           | Beginn            |
| validate | compare_value       | startDate           |                   |
| value    | time                | doorTime            | Einlass           |
| value    | datetime            | endDate             | Ende              |
| value    | select              | eventStatus         | Status            |
| value    | text                | offers_url          | Tickets-URL       |
| value    | text                | offers_price        | Preis             |
| validate | type                | offers_price        |                   |
| value    | select              | offers_availability | Verfügbarkeit     |
| validate | type                | url                 |                   |

Die Felder und Feldnamen orientieren sich dabei am [JSON+LD-Standard für Veranstaltungen](https://jsonld.com/event/), die wichtigsten Validierungen wurden bereits eingefügt.

### Die Tabelle "KATEGORIEN"

Die Tabelle Kategorien kann frei verändert werden, um Termine zu gruppieren (bspw. Veranstaltungsreihen) oder zu Verschlagworten (als Tags).

| Typ      | Typname             | Name    | Bezeichnung |
|----------|---------------------|---------|-------------|
| value    | text                | name    | Titel       |
| validate | unique              | name    |             |
| validate | empty               | name    |             |
| value    | be_media            | image   | Bildmotiv   |
| value    | choice              | status  | Status      |
| value    | be_manager_relation | date_id | Termine     |

### Die Tabelle "LOCATION"

Die Tabelle Location enthält die passenden Veranstaltungsorte zu den Veranstaltungen. Sie wurde im Hinblick auf leichte Geocodierung erstellt, lässt sich aber beliebig um zusätzliche Informationen erweitern.

| Typname | Name        | Bezeichnung | Funktion           |
|---------|-------------|-------------|--------------------|
| value   | text        | name        | Name               |
| value   | text        | street      | Straße, Hausnummer |
| value   | text        | zip         | PLZ                |
| value   | text        | locality    | Stadt              |
| value   | osm_geocode | lat_lng     | Geoposition        |
| value   | text        | lat         | Latitude           |
| value   | text        | lng         | Lng                |

Die Felder und Feldnamen orientieren sich dabei am [JSON+LD-Standard für Veranstaltungen](https://jsonld.com/event/), die wichtigsten Validierungen wurden bereits eingefügt.

## Nutzung im Frontend

### Die Klasse `event_date`

Typ `rex_yform_manager_dataset`. Greift auf die Tabelle `rex_event_date` zu.

#### Zusätzliche Methoden

`getCategory()` holt die passende Kategorie als `event_category`-Objekt.

### Die Klasse `event_category`

Typ `rex_yform_manager_dataset`. Greift auf die Tabelle `rex_event_category` zu.

### Die Klasse `event_location`

Typ `rex_yform_manager_dataset`. Greift auf die Tabelle `rex_event_location_` zu.

## RESTful API (dev)

Die [Rest-API](https://github.com/yakamara/redaxo_yform/blob/master/docs/plugins.md#restful-api-einf%C3%BChrung) ist über das REST-Plugin von YForm umgesetzt.

### Einrichtung

Zunächst das REST-Plugin von YForm installieren und einen Token einrichten. Den Token auf die jeweiligen Endpunkte legen:

```php
    /v0.dev/event/date
    /v0.dev/event/category
    /v0.dev/event/location
```

### Endpunkt `date`

**Auslesen:** GET `example.org/rest/v0.dev/event/date/?token=###TOKEN###`

**Auslesen einzelner Termin**  GET `example.org/rest/v0.dev/event/date/7/?token=###TOKEN###` Termin  der `id=7`


### Endpunkt `category`

**Auslesen:** GET `example.org/rest/v0.dev/event/category/?token=###TOKEN###`

**Auslesen einzelne Kategorie**  GET `example.org/rest/v0.dev/event/category/7/?token=###TOKEN###` Termin  der `id=7`


### Endpunkt `location`

**Auslesen:** GET `example.org/rest/v0.dev/event/location/?token=###TOKEN###`

**Auslesen einzelner Standort**  GET `example.org/rest/v0.dev/event/location/7/?token=###TOKEN###` Termin  der `id=7`

## Lizenz

MIT Lizenz, siehe [LICENSE.md](https://github.com/alexplusde/events/blob/master/LICENSE.md)  

## Autor

**Alexander Walther**  
http://www.alexplus.de  
https://github.com/alexplusde  

**Projekt-Lead**  
[Alexander Walther](https://github.com/alexplusde)

## Credits

events basiert auf: [YForm](https://github.com/yakamara/redaxo_yform)  
Danke an [Gregor Harlan](https://github.com/gharlan) für die Unterstützung