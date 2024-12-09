
# Die Klasse `Date`

Typ `rex_yform_manager_dataset`. Greift auf die Tabelle `rex_event_date` zu.

## Beispiel-Ausgabe eines Termins

```php
dump(event_date::get(3)); // Termin mit der id=3
```

## Zusätzliche Methoden

| Methode                       | Beschreibung                                                                                                                         |
|-------------------------------|--------------------------------------------------------------------------------------------------------------------------------------|
| `getName()`                   | Titel der Veranstaltung                                                                                                              |
| `getDescription()`            | Beschreibungstext                                                                                                                    |
| `getTeaser()`                 | Unformatierter Teaser-Text                                                                                                           |
| `getCategory()`               | holt die passende Kategorie als `Category` -Dataset.                                                                            |
| `getLocation()`               | holt den passenden Veranstaltungsort als `event_location`-Dataset.                                                                   |
| `getOfferAll()`               | holt die passenden Angebote / Preise als `event_offer`-Dataset                                                                       |
| `getImage()`                  | gibt den Bild-Dateinamen aus dem Medienpool zurück                                                                                   |
| `getMedia()`                  | gibt ein REDAXO-Medienobjekt des Bildes zurück                                                                                       |
| `getIcs()`                    | gibt eine ICS-Datei zur Veranstaltung zurück                                                                                         |
| `getDescriptionAsPlaintext()` | gibt die Veranstaltungsbeschreibung als Plaintext zurück                                                                             |
| `getIcsStatus()`              | gibt den Status zurück, wie er im ICS-Format erwartet wird.                                                                          |
| `getUid()`                    | gibt eine UID zurück, wie sie im ICS-Format erwartet wird. Wenn es die UID noch nicht gibt, wird sie automatisch erzeugt.            |
| `getJsonLd()`                 | gibt den JSON-LD-Code zur Veranstaltung zurück                                                                                       |
| `getStartDate()`              | gibt ein DateTime-Objekt zurück mit dem korrekten Startdatum in Abhängigkeit von den gewählten Optionen (ganztägig)                  |
| `getEndDate()`                | gibt ein DateTime-Objekt zurück mit dem korrekten Enddatum, sofern vorhanden, in Abhängigkeit von den gewählten Optionen (ganztägig) |

```php
dump(event_date::get(3)->getCategory()); // Kategorie des Termins mit der id=3
```
