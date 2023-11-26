# event_registration_person

Die `event_registration_person` Klasse repräsentiert eine Person, die sich für ein Event registriert hat.

Sie erbt von der `rex_yform_manager_dataset` Klasse.

Beispiel:

```php
$person = new event_registration_person();
$person->setName("Max Mustermann");
$person->save();
```

## Methoden

### getName

Gibt den Namen der registrierten Person zurück.

Beispiel:

```php
$name = $eventRegistrationPerson->getName();
```

### getFirstName

Gibt den Vornamen der registrierten Person zurück.

Beispiel:

```php
$firstName = $eventRegistrationPerson->getFirstName();
```

### getLastName

Gibt den Nachnamen der registrierten Person zurück.

Beispiel:

```php
$lastName = $eventRegistrationPerson->getLastName();
```

### getMail

Gibt die E-Mail-Adresse der registrierten Person zurück.

Beispiel:

```php
$mail = $eventRegistrationPerson->getMail();
```

### getPhone

Gibt die Telefonnummer der registrierten Person zurück.

Beispiel:

```php
$phone = $eventRegistrationPerson->getPhone();
```

### getBirthday

Gibt das Geburtsdatum der registrierten Person zurück.

Beispiel:

```php
$birthday = $eventRegistrationPerson->getBirthday();
```

### getBirthdayFormatted

Gibt das formatierte Geburtsdatum der registrierten Person zurück.

Beispiel:

```php
$formattedBirthday = $eventRegistrationPerson->getBirthdayFormatted("d.m.Y");
```

### getStatus

Gibt den Status der registrierten Person zurück.

Beispiel:

```php
$status = $eventRegistrationPerson->getStatus();
```

### getEventDateId

Gibt die ID des Event-Datums zurück, für das sich die Person registriert hat.

Beispiel:

```php
$eventDateId = $eventRegistrationPerson->getEventDateId();
```

### getEventDate

Gibt das Event-Datum zurück, für das sich die Person registriert hat.

Beispiel:

```php
$eventDate = $eventRegistrationPerson->getEventDate();
```

### getRegistrationId

Gibt die ID der Registrierung zurück.

Beispiel:

```php
$registrationId = $eventRegistrationPerson->getRegistrationId();
```

### getRegistration

Gibt die Registrierung zurück, für die die Person registriert ist.

Beispiel:

```php
$registration = $eventRegistrationPerson->getRegistration();
```

### getCategoryId

Gibt die ID der Kategorie zurück, für die die Person registriert ist.

Beispiel:

```php
$categoryId = $eventRegistrationPerson->getCategoryId();
```

### getHash

Gibt den Hash der registrierten Person zurück.

Beispiel:

```php
$hash = $eventRegistrationPerson->getHash();
```

### getByUuid

Gibt die registrierte Person zurück, die der angegebenen UUID entspricht.

Beispiel:

```php
$person = event_registration_person::getByUuid("123e4567-e89b-12d3-a456-426614174000");
```

### getByHash

Gibt die registrierte Person zurück, die dem angegebenen Hash entspricht.

Beispiel:

```php
$person = event_registration_person::getByHash("123abc456def");
```

### ep_saved

Wird aufgerufen, wenn ein Datensatz gespeichert wird.

Beispiel:

```php
$result = event_registration_person::ep_saved($ep);
```
