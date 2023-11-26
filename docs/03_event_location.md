# Dokumentation der `event_location` Klasse

Die `event_location` Klasse repräsentiert einen Veranstaltungsort. Sie erbt von der `rex_yform_manager_dataset` Klasse und bietet zusätzliche Methoden zur Interaktion mit den Veranstaltungsorten.

```php
// Erstellt einen neuen Veranstaltungsort
$location = new event_location();
$location->setValue('name', 'Konzerthalle');
$location->save();
```

## Methoden

### `getFormattedAddress()`

Gibt die formatierte Adresse zurück.

```php
$formattedAddress = $location->getFormattedAddress();
```

### `getName()`

Gibt den Namen des Veranstaltungsorts zurück.

```php
$name = $location->getName();
```

### `getZip()`

Gibt die Postleitzahl des Veranstaltungsorts zurück.

```php
$zip = $location->getZip();
```

### `getLocality()`

Gibt die Ortschaft des Veranstaltungsorts zurück.

```php
$locality = $location->getLocality();
```

### `getCity()`

Gibt die Stadt des Veranstaltungsorts zurück.

```php
$city = $location->getCity();
```

### `getCountryCode()`

Gibt den Ländercode des Veranstaltungsorts zurück.

```php
$countryCode = $location->getCountryCode();
```

### `getLatLng()`

Gibt die geographischen Koordinaten des Veranstaltungsorts zurück.

```php
$latLng = $location->getLatLng();
```

### `getLat()`

Gibt den Breitengrad des Veranstaltungsorts zurück.

```php
$lat = $location->getLat();
```

### `getLng()`

Gibt den Längengrad des Veranstaltungsorts zurück.

```php
$lng = $location->getLng();
```
