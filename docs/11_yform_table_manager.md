
# Tabellen und Datenbankstruktur

## Die Tabelle "SPRACHEN"

Die Tabelle "TERMINE" mit Flaggen-Symbol ist eine Tabelle, in der zunächst Sprachen verwaltet werden können und im Anschluss die eigentliche Termin-Tabelle gefiltert nach dieser Sprache angezeigt wird.

Wer keine mehrsprachigen Termine benötigt, kann diesen Menüpunkt problemlos für Redakteure über die Benutzer-Rollen ausblenden. Wichtig ist jedoch, dass mind. eine Sprache angelegt wurde.

## Die Tabelle "TERMINE"

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

## Die Tabelle "KATEGORIEN"

Die Tabelle Kategorien kann frei verändert werden, um Termine zu gruppieren (bspw. Veranstaltungsreihen) oder zu Verschlagworten (als Tags).

| Typ      | Typname             | Name    | Bezeichnung |
|----------|---------------------|---------|-------------|
| value    | text                | name    | Titel       |
| validate | unique              | name    |             |
| validate | empty               | name    |             |
| value    | be_media            | image   | Bildmotiv   |
| value    | choice              | status  | Status      |
| value    | be_manager_relation | date_id | Termine     |

## Die Tabelle "ANGEBOTE"

Die Tabelle Angebote enthält optional Ticket-URL und Preise für Veranstaltungen.

| Typ      | Typname             | Name    | Bezeichnung   |
|----------|---------------------|---------|---------------|
| value    | text                | name    | Titel         |
| value    | text                | price   | Preis         |
| value    | choice              | status  | Verfügbarkeit |
| value    | be_manager_relation | date_id | Termin        |

## Die Tabelle "LOCATION"

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
