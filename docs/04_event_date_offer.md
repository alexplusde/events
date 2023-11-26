# Dokumentation der `event_date_offer` Klasse

Die `event_date_offer` Klasse repräsentiert ein Angebot für ein bestimmtes Event-Datum. Sie erbt von der `rex_yform_manager_dataset` Klasse und bietet zusätzliche Methoden zur Interaktion mit den Angeboten eines Event-Datums.

```php
// Erstellt ein neues Angebot für ein Event-Datum
$offer = new event_date_offer();
$offer->setValue('event_date_id', $eventDateId);
$offer->setValue('price', $price);
$offer->setValue('avaialabiility', $price);
$offer->save();
```

## Methoden

### `getUrl()`

Gibt die URL des Angebots zurück.

```php
$url = $offer->getUrl();
```

### `getStatus()`

Gibt den Status des Angebots zurück.

```php
$status = $offer->getStatus();
```

### `getPrice()`

Gibt den Preis des Angebots zurück.

```php
$price = $offer->getPrice();
```

### `getCurrency()`

Gibt die Währung des Angebots zurück.

```php
$currency = $offer->getCurrency();
```

### `getPriceFormatted()`

Gibt den formatierten Preis des Angebots zurück.

```php
$priceFormatted = $offer->getPriceFormatted();
```

### `getAvailability()`

Gibt die Verfügbarkeit des Angebots als schema.org kompatiblen Wert zurück.

```php
$availability = $offer->getAvailability();
```
