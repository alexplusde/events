# Veranstaltungskalender, Terminbuchung, Terminanfragen, Anmeldungen und Teilnehmerlisten für REDAXO ^5.17 und YForm ^4

![web_banner_redaxo_addon_events](https://user-images.githubusercontent.com/3855487/204768716-fa9f5a97-c1de-421a-aea0-2a0ce8658813.png)

Mit diesem Addon können Termine anhand von YForm und YOrm im Backend verwaltet und im Frontend ausgegeben werden. Auf Wunsch auch mehrsprachig.

## Features

* Vollständig mit **YForm** umgesetzt: Alle Features und Anpassungsmöglichkeiten von YForm verfügbar
* Einfach: Die Ausgabe erfolgt über [`rex_sql`](https://redaxo.org/doku/master/datenbank-queries) oder objektorientiert über [YOrm](https://github.com/yakamara/redaxo_yform_docs/blob/master/de_de/yorm.md)
* Flexibel: **Zugriff** über die [YForm Rest-API](https://github.com/yakamara/redaxo_yform/blob/master/docs/plugins.md#restful-api-einf%C3%BChrung)
* Sinnvoll: Nur ausgewählte **Rollen**/Redakteure haben Zugriff
* Bereit für **mehrsprachige** Websites: Reiter für Sprachen auf Wunsch anzeigen oder ausblenden
* Bereit für mehr: Vorbereitet für das [JSON+LD-Format](https://jsonld.com/event/), ICS-Format
* Bereit für viel mehr: Kompatibel zum [URL2-Addon](https://github.com/tbaddade/redaxo_url)
* Mächtig: Datenbank-Struktur für **Anmeldeformulare** und einfache Teilnehmerlisten vorbereitet
* Umfangreich dokumentiert und in aktiver Weiterentwicklung

> **Tipp:** Events arbeitet hervorragend zusammen mit den Addons [`yform_usability`](https://github.com/FriendsOfREDAXO/yform_usability/) und [`yform_geo_osm`](https://github.com/FriendsOfREDAXO/yform_geo_osm)

> **Steuere eigene Verbesserungen** dem [GitHub-Repository von events](https://github.com/alexplusde/events) bei. Oder **unterstütze dieses Addon:** Mit einer [Spende oder Beauftragung unterstützt du die Weiterentwicklung dieses AddOns](https://github.com/sponsors/alexplusde)

## Installation

Im REDAXO-Installer das Addon `events` herunterladen und installieren. Anschließend erscheint ein neuer Menüpunkt `Veranstaltungen` sichtbar.

## Nutzung im Frontend

Siehe Dokumentation im Addon

## Formulare

### Die YForm-Action `event_date_registration_person_fill`

Nutze diese Action, wenn in einer Anmeldung sogleich Teilnehmende in einer Tabelle "Teilnehmende" erfolgen soll:

```php
    $yform->setActionField('event_date_registration_person_fill', array(""));
```

Dabei wird die Tabelle `rex_event_date_registration_person` automatisch mit der Anzahl der anzumeldenden Teilnehmenden befüllt.

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
