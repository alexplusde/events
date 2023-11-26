# Veranstaltungskalender, Terminbuchung, Terminanfragen, Anmeldungen und Teilnehmerlisten für REDAXO 5 auf YForm-Basis

![web_banner_redaxo_addon_events](https://user-images.githubusercontent.com/3855487/204768716-fa9f5a97-c1de-421a-aea0-2a0ce8658813.png)

Mit diesem Addon können Termine anhand von YForm und YOrm im Backend verwaltet und im Frontend ausgegeben werden. Auf Wunsch auch mehrsprachig.

**Beispiele**

![event](https://user-images.githubusercontent.com/3855487/180771758-d4a2e4ba-3034-4e96-8e1d-4cc5333de615.png)

![event_date](https://user-images.githubusercontent.com/3855487/180771781-0f2cc875-3561-47e2-a3bb-50752177afa3.png)

![event_settings](https://user-images.githubusercontent.com/3855487/180771783-1973c380-79af-42d6-9b14-babcc4378b3c.png)

![event_category](https://user-images.githubusercontent.com/3855487/180771784-2baad1bb-052e-4dbf-aa64-ef93e1892875.png)

## Features

* Vollständig mit **YForm** umgesetzt: Alle Features und Anpassungsmöglichkeiten von YForm verfügbar
* Einfach: Die Ausgabe erfolgt über [`rex_sql`](https://redaxo.org/doku/master/datenbank-queries) oder objektorientiert über [YOrm](https://github.com/yakamara/redaxo_yform_docs/blob/master/de_de/yorm.md)
* Flexibel: **Zugriff** über die [YForm Rest-API](https://github.com/yakamara/redaxo_yform/blob/master/docs/plugins.md#restful-api-einf%C3%BChrung)
* Sinnvoll: Nur ausgewählte **Rollen**/Redakteure haben Zugriff
* Bereit für **mehrsprachige** Websites: Reiter für Sprachen auf Wunsch anzeigen oder ausblenden
* Bereit für mehr: Vorbereitet für das [JSON+LD-Format](https://jsonld.com/event/), ICS-Format
* Bereit für viel mehr: Kompatibel zum [URL2-Addon](https://github.com/tbaddade/redaxo_url)
* Mächtig: Datenbank-Struktur für **Anmeldeformulare** und einfache Teilnehmerlisten vorbereitet

> **Tipp:** Events arbeitet hervorragend zusammen mit den Addons [`yform_usability`](https://github.com/FriendsOfREDAXO/yform_usability/) und [`yform_geo_osm`](https://github.com/FriendsOfREDAXO/yform_geo_osm)

> **Steuere eigene Verbesserungen** dem [GitHub-Repository von events](https://github.com/alexplusde/events) bei. Oder **unterstütze dieses Addon:** Mit einer [Spende oder Beauftragung unterstützt du die Weiterentwicklung dieses AddOns](https://github.com/sponsors/alexplusde)

## RESTful API (dev)

Die [Rest-API](https://github.com/yakamara/redaxo_yform/blob/master/docs/plugins.md#restful-api-einf%C3%BChrung) ist über das REST-Plugin von YForm umgesetzt.

### Einrichtung

Zunächst das REST-Plugin von YForm installieren und einen Token einrichten. Den Token auf die jeweiligen Endpunkte legen:

```php
    /v2.0/event/date
    /v2.0/event/category
    /v2.0/event/location
```

### Endpunkt `date`

**Auslesen:** GET `example.org/rest/v2.0/event/date/?token=###TOKEN###`

**Auslesen einzelner Termin**  GET `example.org/rest/v0.dev/event/date/7/?token=###TOKEN###` Termin  der `id=7`

### Endpunkt `category`

**Auslesen:** GET `example.org/rest/v2.0/event/category/?token=###TOKEN###`

**Auslesen einzelne Kategorie**  GET `example.org/rest/v0.dev/event/category/7/?token=###TOKEN###` Termin  der `id=7`

### Endpunkt `location`

**Auslesen:** GET `example.org/rest/v2.0/event/location/?token=###TOKEN###`

**Auslesen einzelner Standort**  GET `example.org/rest/v0.dev/event/location/7/?token=###TOKEN###` Termin  der `id=7`

## Import

### Import von ICS-Kalendern (dev)

Events kommt mit einem eigenen Cronjob zum importieren von ics-Kalendern aus dem Internet. Das Cronjob-Addon aufrufen, einen neuen Cronjob anlegen und den Instruktionen folgen.

## Export

## Export eines einzelnen Termins als ics-Datei (dev)

Events kommt mit einer eigenen rex_api-Schnittstelle für den Export von einzelnen Terminen. `?rex-api-call=events_ics_file&id=2` aufrufen, um eine ICS-Datei anhand des Termins mit der `id=2` zu erzeugen.

## Lizenz

MIT Lizenz, siehe [LICENSE.md](https://github.com/alexplusde/events/blob/master/LICENSE.md)  

## Autoren

**Alexander Walther**  
<http://www.alexplus.de>  
<https://github.com/alexplusde>  

**Michael Schuler**
<https://github.com/191977>

**Projekt-Lead**  
[Alexander Walther](https://github.com/alexplusde)

## Credits

events basiert auf: [YForm](https://github.com/yakamara/redaxo_yform)  
Danke an [Gregor Harlan](https://github.com/gharlan) für die Unterstützung
Danke an den Kulturkeller e.V. für die Beauftragung für die Weiterentwicklung
