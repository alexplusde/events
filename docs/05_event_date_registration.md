# event_registration Klasse

## Methoden

### getPhone

Gibt die Telefonnummer der Registrierung zurück.

Beispiel:

```php
$phone = $eventRegistration->getPhone();
```

### getBirthday

Gibt das Geburtsdatum der Registrierung zurück.

Beispiel:

```php
$birthday = $eventRegistration->getBirthday();
```

### getBirthdayFormatted

Gibt das formatierte Geburtsdatum der Registrierung zurück.

Beispiel:

```php
$formattedBirthday = $eventRegistration->getBirthdayFormatted("d.m.Y");
```

### getPayment

Gibt die Zahlungsart der Registrierung zurück.

Beispiel:

```php
$payment = $eventRegistration->getPayment();
```

### getMessage

Gibt die Nachricht der Registrierung zurück.

Beispiel:

```php
$message = $eventRegistration->getMessage();
```

### getChannel

Gibt den Kanal der Registrierung zurück.

Beispiel:

```php
$channel = $eventRegistration->getChannel();
```

### getStatus

Gibt den Status der Registrierung zurück.

Beispiel:

```php
$status = $eventRegistration->getStatus();
```

### getPrice

Gibt den Preis der Registrierung zurück.

Beispiel:

```php
$price = $eventRegistration->getPrice();
```

### getUuid

Gibt die UUID der Registrierung zurück.

Beispiel:

```php
$uuid = $eventRegistration->getUuid();
```

### hasAcceptedNewsletter

Gibt zurück, ob die Registrierung den Newsletter akzeptiert hat.

Beispiel:

```php
$hasAcceptedNewsletter = $eventRegistration->hasAcceptedNewsletter();
```

### hasAcceptedAgb

Gibt zurück, ob die Registrierung die AGB akzeptiert hat.

Beispiel:

```php
$hasAcceptedAgb = $eventRegistration->hasAcceptedAgb();
```

### hasAcceptedPrivacyPolicy

Gibt zurück, ob die Registrierung die Datenschutzrichtlinie akzeptiert hat.

Beispiel:

```php
$hasAcceptedPrivacyPolicy = $eventRegistration->hasAcceptedPrivacyPolicy();
```

### getByUuid

Gibt die Registrierung mit der gegebenen UUID zurück.

Beispiel:

```php
$registration = event_registration::getByUuid($uuid);
```

### getHash

Gibt den Hash der Registrierung zurück.

Beispiel:

```php
$hash = $eventRegistration->getHash();
```

### getByHash

Gibt die Registrierung mit dem gegebenen Hash zurück.

Beispiel:

```php
$registration = event_registration::getByHash($hash);
```
