<?php

/**
 * Die `event_registration_person` Klasse repräsentiert eine Person, die sich für ein Event registriert hat.
 *
 * Sie erbt von der `rex_yform_manager_dataset` Klasse.
 *
 * Beispiel:
 * ```php
 * $person = new event_registration_person();
 * $person->setName("Max Mustermann");
 * $person->save();
 * ```
 *
 * ---
 *
 * The `event_registration_person` class represents a person who has registered for an event.
 *
 * It inherits from the `rex_yform_manager_dataset` class.
 *
 * Example:
 * ```php
 * $person = new event_registration_person();
 * $person->setName("John Doe");
 * $person->save();
 * ```
 */
class event_registration_person extends \rex_yform_manager_dataset
{
    /**
     * Gibt den Namen der registrierten Person zurück.
     *
     * @param bool $reverse Wenn true, wird der Nachname vor dem Vornamen zurückgegeben. Standardwert ist false.
     * @return string Der Name der registrierten Person.
     *
     * Beispiel:
     * ```php
     * $name = $eventRegistrationPerson->getName();
     * ```
     *
     * ---
     *
     * Returns the name of the registered person.
     *
     * @param bool $reverse If true, the last name is returned before the first name. Default is false.
     * @return string The name of the registered person.
     *
     * Example:
     * ```php
     * $name = $eventRegistrationPerson->getName();
     * ```
     */
    public function getName(bool $reverse = false): string
    {
        $name = [];
        if ($reverse) {
            $name[] = $this->getLastName() . ",";
            $name[] = $this->getFirstName();
        }
        if (!$reverse) {
            $name[] = $this->getFirstName();
            $name[] = $this->getLastName();
        }
        return implode(" ", $name);
    }
    /**
     * Gibt den Vornamen der registrierten Person zurück.
     *
     * @return string Der Vorname der registrierten Person.
     *
     * Beispiel:
     * ```php
     * $firstName = $eventRegistrationPerson->getFirstName();
     * ```
     *
     * ---
     *
     * Returns the first name of the registered person.
     *
     * @return string The first name of the registered person.
     *
     * Example:
     * ```php
     * $firstName = $eventRegistrationPerson->getFirstName();
     * ```
     */
    public function getFirstName(): string
    {
        return $this->getValue('firstname');
    }
    public function setFirstName(string $firstName): self
    {
        $this->setValue('firstname', $firstName);
        return $this;
    }

    /**
     * Gibt den Nachnamen der registrierten Person zurück.
     *
     * @return string Der Nachname der registrierten Person.
     *
     * Beispiel:
     * ```php
     * $lastName = $eventRegistrationPerson->getLastName();
     * ```
     *
     * ---
     *
     * Returns the last name of the registered person.
     *
     * @return string The last name of the registered person.
     *
     * Example:
     * ```php
     * $lastName = $eventRegistrationPerson->getLastName();
     * ```
     */
    public function getLastName(): string
    {
        return $this->getValue('lastname');
    }
    public function setLastName(string $lastName): self
    {
        $this->setValue('lastname', $lastName);
        return $this;
    }

    /**
     * Gibt die E-Mail-Adresse der registrierten Person zurück.
     *
     * @return string Die E-Mail-Adresse der registrierten Person.
     *
     * Beispiel:
     * ```php
     * $mail = $eventRegistrationPerson->getMail();
     * ```
     *
     * ---
     *
     * Returns the email address of the registered person.
     *
     * @return string The email address of the registered person.
     *
     * Example:
     * ```php
     * $mail = $eventRegistrationPerson->getMail();
     * ```
     */
    public function getMail(): string
    {
        return $this->getValue('email');
    }
    public function setMail(string $mail): self
    {
        $this->setValue('email', $mail);
        return $this;
    }
    /**
     * Gibt die Telefonnummer der registrierten Person zurück.
     *
     * @return string Die Telefonnummer der registrierten Person.
     *
     * Beispiel:
     * ```php
     * $phone = $eventRegistrationPerson->getPhone();
     * ```
     *
     * ---
     *
     * Returns the phone number of the registered person.
     *
     * @return string The phone number of the registered person.
     *
     * Example:
     * ```php
     * $phone = $eventRegistrationPerson->getPhone();
     * ```
     */
    public function getPhone(): string
    {
        return $this->getValue('phone');
    }
    public function setPhone(string $phone): self
    {
        $this->setValue('phone', $phone);
        return $this;
    }

    /**
     * Gibt das Geburtsdatum der registrierten Person zurück.
     *
     * @return string Das Geburtsdatum der registrierten Person.
     *
     * Beispiel:
     * ```php
     * $birthday = $eventRegistrationPerson->getBirthday();
     * ```
     *
     * ---
     *
     * Returns the birthday of the registered person.
     *
     * @return string The birthday of the registered person.
     *
     * Example:
     * ```php
     * $birthday = $eventRegistrationPerson->getBirthday();
     * ```
     */
    public function getBirthday(): string
    {
        return $this->getValue('birthday');
    }
    public function setBirthday(string $birthday): self
    {
        $this->setValue('birthday', $birthday);
        return $this;
    }

    /**
     * Gibt das formatierte Geburtsdatum der registrierten Person zurück.
     *
     * @param string $format Das Datumsformat. Standardwert ist "Y-m-d H:i:s".
     * @return string Das formatierte Geburtsdatum der registrierten Person.
     *
     * Beispiel:
     * ```php
     * $formattedBirthday = $eventRegistrationPerson->getBirthdayFormatted("d.m.Y");
     * ```
     *
     * ---
     *
     * Returns the formatted birthday of the registered person.
     *
     * @param string $format The date format. Default is "Y-m-d H:i:s".
     * @return string The formatted birthday of the registered person.
     *
     * Example:
     * ```php
     * $formattedBirthday = $eventRegistrationPerson->getBirthdayFormatted("m/d/Y");
     * ```
     */
    public function getBirthdayFormatted(string $format = "Y-m-d H:i:s") :string
    {
        if ($this->getBirthday() == "0000-00-00") {
            return "";
        } else {
            $date = date_create($this->getBirthday());
            return date_format($date, $format);
        }
    }
    /**
     * Gibt den Status der registrierten Person zurück.
     *
     * @return int Der Status der registrierten Person.
     *
     * Beispiel:
     * ```php
     * $status = $eventRegistrationPerson->getStatus();
     * ```
     *
     * ---
     *
     * Returns the status of the registered person.
     *
     * @return int The status of the registered person.
     *
     * Example:
     * ```php
     * $status = $eventRegistrationPerson->getStatus();
     * ```
     */
    public function getStatus(): int
    {
        return $this->getValue('status');
    }
    public function setStatus(int $status): self
    {
        $this->setValue('status', $status);
        return $this;
    }
    /**
     * Gibt die ID des Event-Datums zurück, für das sich die Person registriert hat.
     *
     * @return int Die ID des Event-Datums.
     *
     * Beispiel:
     * ```php
     * $eventDateId = $eventRegistrationPerson->getEventDateId();
     * ```
     *
     * ---
     *
     * Returns the ID of the event date for which the person has registered.
     *
     * @return int The ID of the event date.
     *
     * Example:
     * ```php
     * $eventDateId = $eventRegistrationPerson->getEventDateId();
     * ```
     */
    public function getEventDateId(): int
    {
        return $this->getValue('event_date_id');
    }
    public function setEventDateId(int $eventDateId): self
    {
        $this->setValue('event_date_id', $eventDateId);
        return $this;
    }
    /**
     * Gibt das Event-Datum zurück, für das sich die Person registriert hat.
     *
     * @return event_date|null Das Event-Datum oder null, wenn kein Event-Datum gesetzt ist.
     *
     * Beispiel:
     * ```php
     * $eventDate = $eventRegistrationPerson->getEventDate();
     * ```
     *
     * ---
     *
     * Returns the event date for which the person has registered.
     *
     * @return event_date|null The event date or null if no event date is set.
     *
     * Example:
     * ```php
     * $eventDate = $eventRegistrationPerson->getEventDate();
     * ```
     */
    public function getEventDate(): ?event_date
    {
        return $this->getRelatedDataset('event_date_id');
    }
    /**
     * Gibt die ID der Registrierung zurück.
     *
     * @return int Die ID der Registrierung.
     *
     * Beispiel:
     * ```php
     * $registrationId = $eventRegistrationPerson->getRegistrationId();
     * ```
     *
     * ---
     *
     * Returns the ID of the registration.
     *
     * @return int The ID of the registration.
     *
     * Example:
     * ```php
     * $registrationId = $eventRegistrationPerson->getRegistrationId();
     * ```
     */
    public function getRegistrationId(): int
    {
        return $this->getValue('registration_id');
    }
    public function setRegistrationId(int $registrationId): self
    {
        $this->setValue('registration_id', $registrationId);
        return $this;
    }
    /**
     * Gibt die Registrierung zurück, für die die Person registriert ist.
     *
     * @return rex_yform_manager_dataset|null Die Registrierung oder null, wenn keine Registrierung gesetzt ist.
     *
     * Beispiel:
     * ```php
     * $registration = $eventRegistrationPerson->getRegistration();
     * ```
     *
     * ---
     *
     * Returns the registration for which the person is registered.
     *
     * @return rex_yform_manager_dataset|null The registration or null if no registration is set.
     *
     * Example:
     * ```php
     * $registration = $eventRegistrationPerson->getRegistration();
     * ```
     */
    public function getRegistration(): ?rex_yform_manager_dataset
    {
        return $this->getRelatedDataset('registration_id');
    }

    /**
     * Gibt die ID der Kategorie zurück, für die die Person registriert ist.
     *
     * @return int Die ID der Kategorie.
     *
     * Beispiel:
     * ```php
     * $categoryId = $eventRegistrationPerson->getCategoryId();
     * ```
     *
     * ---
     *
     * Returns the ID of the category for which the person is registered.
     *
     * @return int The ID of the category.
     *
     * Example:
     * ```php
     * $categoryId = $eventRegistrationPerson->getCategoryId();
     * ```
     */
    public function getCategoryId(): int
    {
        /** @var event_registration $registration */
        $registration = $this->getRegistration();
        /** @var event_category $category */
        $category = $registration->getCategory();
        return $category->getId();
    }
    /**
     * Gibt den Hash der registrierten Person zurück.
     *
     * @return string Der Hash der registrierten Person.
     *
     * Beispiel:
     * ```php
     * $hash = $eventRegistrationPerson->getHash();
     * ```
     *
     * ---
     *
     * Returns the hash of the registered person.
     *
     * @return string The hash of the registered person.
     *
     * Example:
     * ```php
     * $hash = $eventRegistrationPerson->getHash();
     * ```
     */
    public function getHash(): string
    {
        return $this->getValue('hash');
    }
    public function setHash(string $hash): self
    {
        $this->setValue('hash', $hash);
        return $this;
    }

    /**
     * Gibt die registrierte Person zurück, die der angegebenen UUID entspricht.
     *
     * @param string|null $uuid Die UUID der gesuchten Person. Wenn null, wird null zurückgegeben.
     * @return event_registration_person|null Die registrierte Person oder null, wenn keine Person gefunden wurde.
     *
     * Beispiel:
     * ```php
     * $person = event_registration_person::getByUuid("123e4567-e89b-12d3-a456-426614174000");
     * ```
     *
     * ---
     *
     * Returns the registered person that corresponds to the specified UUID.
     *
     * @param string|null $uuid The UUID of the person being sought. If null, null is returned.
     * @return event_registration_person|null The registered person or null if no person was found.
     *
     * Example:
     * ```php
     * $person = event_registration_person::getByUuid("123e4567-e89b-12d3-a456-426614174000");
     * ```
     */
    public static function getByUuid(string $uuid = null): ?event_registration_person
    {
        if (!$uuid) {
            return null;
        }
        return self::query()->where('uuid', $uuid)->findOne();
    }
    /**
     * Gibt die registrierte Person zurück, die dem angegebenen Hash entspricht.
     *
     * @param string|null $hash Der Hash der gesuchten Person. Wenn null, wird null zurückgegeben.
     * @return event_registration_person|null Die registrierte Person oder null, wenn keine Person gefunden wurde.
     *
     * Beispiel:
     * ```php
     * $person = event_registration_person::getByHash("123abc456def");
     * ```
     *
     * ---
     *
     * Returns the registered person that corresponds to the specified hash.
     *
     * @param string|null $hash The hash of the person being sought. If null, null is returned.
     * @return event_registration_person|null The registered person or null if no person was found.
     *
     * Example:
     * ```php
     * $person = event_registration_person::getByHash("123abc456def");
     * ```
     */
    public static function getByHash(string $hash = null): ?event_registration_person
    {
        if (!$hash) {
            return null;
        }
        return self::query()->where('hash', $hash)->findOne();
    }

    /**
     * Wird aufgerufen, wenn ein Datensatz gespeichert wird.
     *
     * @param rex_extension_point $ep Der Extension Point.
     * @return bool Immer true.
     *
     * Beispiel:
     * ```php
     * $result = event_registration_person::ep_saved($ep);
     * ```
     *
     * ---
     *
     * Called when a record is saved.
     *
     * @param rex_extension_point $ep The extension point.
     * @return bool Always true.
     *
     * Example:
     * ```php
     * $result = event_registration_person::ep_saved($ep);
     * ```
     */
    public static function ep_saved(rex_extension_point $ep): bool
    {
        $lastId = $ep->getSubject()->getLastId();
        $table  = $ep->getParam('table');

        return true;
    }
}
