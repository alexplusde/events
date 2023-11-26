# Klasse event_category

Die `event_category` Klasse repräsentiert eine Kategorie eines Events. Diese Klasse erweitert die
`rex_yform_manager_dataset` Klasse und bietet spezifische Funktionen und Eigenschaften, die für die Verwaltung von
Event-Kategorien notwendig sind.

```php
$eventCategory = new event_category();
```

## Methoden

### getName()

Gibt den Namen der Kategorie zurück.

```php
$name = $eventCategory->getName();
```

### getImage()

Gibt das Bild der Kategorie zurück.

```php
$image = $eventCategory->getImage();
```

### getMedia()

Gibt das rex_media Objekt des Bildes zurück.

```php
$media = $eventCategory->getMedia();
```

### getIcon()

Gibt das Icon der Kategorie zurück.

```php
$icon = $eventCategory->getIcon();
```

### getPrice()

Gibt den Preis der Kategorie zurück.

```php
$price = $eventCategory->getPrice();
```

### getUrl()

Gibt die URL der Kategorie zurück.

```php
$url = $eventCategory->getUrl();
```

### getDateWhere($whereRaw)

Gibt eine Sammlung von Event-Daten zurück, die auf einem bestimmten Kriterium basieren.

```php
$dates = $eventCategory->getDateWhere('startDate > NOW()');
```

### getRelatedDates($whereRaw)

Gibt eine Sammlung von verwandten Event-Daten zurück.

```php
$relatedDates = $eventCategory->getRelatedDates('startDate > NOW()');
```

### getAttributes()

Gibt ein Array von Attributen zurück.

```php
$attributes = $eventCategory->getAttributes();
```

### hasAttribute($needle)

Überprüft, ob ein bestimmtes Attribut vorhanden ist.

```php
$hasAttribute = $eventCategory->hasAttribute('attributeName');
```
