<?php

class event_registration extends \rex_yform_manager_dataset
{
    /**
     * Gibt die Gesamtzahl der Registrierungen für ein bestimmtes Datum zurück.
     *
     * @param int $date_id Die ID des Datums.
     * @return rex_yform_manager_collection|null Eine Sammlung von Registrierungen oder null, wenn keine gefunden wurden.
     *
     * Beispiel:
     * ```php
     * $totalRegistrations = event_registration::getTotalRegistrationsByDate($date_id);
     * ```
     *
     * ---
     *
     * Returns the total number of registrations for a specific date.
     *
     * @param int $date_id The ID of the date.
     * @return rex_yform_manager_collection|null A collection of registrations or null if none were found.
     *
     * Example:
     * ```php
     * $totalRegistrations = event_registration::getTotalRegistrationsByDate($date_id);
     * ```
     */
    public static function getTotalRegistrationsByDate(int $date_id): ?rex_yform_manager_collection
    {
        return self::query()->where('date_id', $date_id)->where('status', '0', '>=')->find();
    }

    /**
     * Gibt eine Sammlung von registrierten Personen für ein bestimmtes Event zurück.
     *
     * @param int $status Der Status der Registrierung.
     * @param string $operator Der Operator für den Statusvergleich.
     * @return rex_yform_manager_collection|null Eine Sammlung von registrierten Personen oder null, wenn keine gefunden wurden.
     *
     * Beispiel:
     * ```php
     * $registrationPersons = $eventRegistration->getRegistrationPerson(0, ">=");
     * ```
     *
     * ---
     *
     * Returns a collection of registered persons for a specific event.
     *
     * @param int $status The status of the registration.
     * @param string $operator The operator for the status comparison.
     * @return rex_yform_manager_collection|null A collection of registered persons or null if none were found.
     *
     * Example:
     * ```php
     * $registrationPersons = $eventRegistration->getRegistrationPerson(0, ">=");
     * ```
     */
    public function getRegistrationPerson(int $status = 0, string $operator = ">="): ?rex_yform_manager_collection
    {
        return event_registration_person::query()->where('status', $status, $operator)->where('event_date_id', self::getDateId())->find();
    }

    /**
     * Zählt die Anzahl der registrierten Personen für ein bestimmtes Event.
     *
     * @param int $status Der Status der Registrierung.
     * @param string $operator Der Operator für den Statusvergleich.
     * @return int Die Anzahl der registrierten Personen.
     *
     * Beispiel:
     * ```php
     * $count = $eventRegistration->countRegistrationPerson(0, ">=");
     * ```
     *
     * ---
     *
     * Counts the number of registered persons for a specific event.
     *
     * @param int $status The status of the registration.
     * @param string $operator The operator for the status comparison.
     * @return int The number of registered persons.
     *
     * Example:
     * ```php
     * $count = $eventRegistration->countRegistrationPerson(0, ">=");
     * ```
     */
    public function countRegistrationPerson(int $status = 0, string $operator = ">="): int
    {
        return count($this->getRegistrationPerson($status, $operator));
    }
    /**
     * Gibt die Gesamtzahl der Personen für eine bestimmte Registrierung zurück.
     *
     * @return int Die Gesamtzahl der Personen.
     *
     * Beispiel:
     * ```php
     * $personTotal = $eventRegistration->getPersonTotal();
     * ```
     *
     * ---
     *
     * Returns the total number of persons for a specific registration.
     *
     * @return int The total number of persons.
     *
     * Example:
     * ```php
     * $personTotal = $eventRegistration->getPersonTotal();
     * ```
     */
    public function getPersonTotal(): int
    {
        return $this->getValue('person_count');
    }
    public function setPersonTotal(int $personTotal): self
    {
        $this->setValue('person_count', $personTotal);
        return $this;
    }

    /**
     * Wird aufgerufen, wenn ein rex_extension_point gespeichert wird.
     *
     * @param rex_extension_point $ep Der rex_extension_point.
     * @return bool Immer true.
     *
     * Beispiel:
     * ```php
     * $result = event_registration::ep_saved($ep);
     * ```
     *
     * ---
     *
     * Called when a rex_extension_point is saved.
     *
     * @param rex_extension_point $ep The rex_extension_point.
     * @return bool Always true.
     *
     * Example:
     * ```php
     * $result = event_registration::ep_saved($ep);
     * ```
     */
    public static function ep_saved(rex_extension_point $ep): bool
    {
        $lastId = $ep->getSubject()->getLastId();
        $table  = $ep->getParam('table');

        return true;
    }
    /**
     * Gibt die Kategorie-ID der Registrierung zurück.
     *
     * @return int Die Kategorie-ID.
     *
     * Beispiel:
     * ```php
     * $categoryId = $eventRegistration->getCategoryId();
     * ```
     *
     * ---
     *
     * Returns the category ID of the registration.
     *
     * @return int The category ID.
     *
     * Example:
     * ```php
     * $categoryId = $eventRegistration->getCategoryId();
     * ```
     */
    public function getCategoryId(): int
    {
        return $this->getValue('category_id');
    }
    public function setCategoryId(int $categoryId): self
    {
        $this->setValue('category_id', $categoryId);
        return $this;
    }

    /**
     * Gibt die Kategorie der Registrierung zurück.
     *
     * @return rex_yform_manager_dataset|null Eine Sammlung von Kategorien oder null, wenn keine gefunden wurden.
     *
     * Beispiel:
     * ```php
     * $category = $eventRegistration->getCategory();
     * ```
     *
     * ---
     *
     * Returns the category of the registration.
     *
     * @return rex_yform_manager_dataset|null A collection of categories or null if none were found.
     *
     * Example:
     * ```php
     * $category = $eventRegistration->getCategory();
     * ```
     */
    public function getCategory(): ?rex_yform_manager_dataset
    {
        return $this->getRelatedDataset('category_id');
    }

    /**
     * Gibt die Datum-ID der Registrierung zurück.
     *
     * @return int Die Datum-ID.
     *
     * Beispiel:
     * ```php
     * $dateId = $eventRegistration->getDateId();
     * ```
     *
     * ---
     *
     * Returns the date ID of the registration.
     *
     * @return int The date ID.
     *
     * Example:
     * ```php
     * $dateId = $eventRegistration->getDateId();
     * ```
     */
    public function getDateId(): int
    {
        return $this->getValue('date_id');
    }
    public function setDateId(int $dateId): self
    {
        $this->setValue('date_id', $dateId);
        return $this;
    }

    /**
     * Gibt das Datum der Registrierung zurück.
     *
     * @return rex_yform_manager_collection|null Eine Sammlung von Daten oder null, wenn keine gefunden wurden.
     *
     * Beispiel:
     * ```php
     * $date = $eventRegistration->getDate();
     * ```
     *
     * ---
     *
     * Returns the date of the registration.
     *
     * @return rex_yform_manager_collection|null A collection of dates or null if none were found.
     *
     * Example:
     * ```php
     * $date = $eventRegistration->getDate();
     * ```
     */
    public function getDate(): ?rex_yform_manager_collection
    {
        return $this->getRelatedDataset('date_id');
    }

    /**
     * Gibt die ID des Veranstaltungsorts der Registrierung zurück.
     *
     * @return int Die ID des Veranstaltungsorts.
     *
     * Beispiel:
     * ```php
     * $locationId = $eventRegistration->getLocationId();
     * ```
     *
     * ---
     *
     * Returns the location ID of the registration.
     *
     * @return int The location ID.
     *
     * Example:
     * ```php
     * $locationId = $eventRegistration->getLocationId();
     * ```
     */
    public function getLocationId(): int
    {
        return $this->getValue('event_location_id');
    }
    public function setLocationId(int $locationId): self
    {
        $this->setValue('event_location_id', $locationId);
        return $this;
    }

    /**
     * Gibt die Anrede der Registrierung zurück.
     *
     * @return string Die Anrede.
     *
     * Beispiel:
     * ```php
     * $salutation = $eventRegistration->getSalutation();
     * ```
     *
     * ---
     *
     * Returns the salutation of the registration.
     *
     * @return string The salutation.
     *
     * Example:
     * ```php
     * $salutation = $eventRegistration->getSalutation();
     * ```
     */
    public function getSalutation(): string
    {
        return $this->getValue('salutation');
    }
    public function setSalutation(string $salutation): self
    {
        $this->setValue('salutation', $salutation);
        return $this;
    }

    /**
     * Gibt den Vornamen der Registrierung zurück.
     *
     * @return string Der Vorname.
     *
     * Beispiel:
     * ```php
     * $firstName = $eventRegistration->getFirstName();
     * ```
     *
     * ---
     *
     * Returns the first name of the registration.
     *
     * @return string The first name.
     *
     * Example:
     * ```php
     * $firstName = $eventRegistration->getFirstName();
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
     * Gibt den Nachnamen der Registrierung zurück.
     *
     * @return string Der Nachname.
     *
     * Beispiel:
     * ```php
     * $lastName = $eventRegistration->getLastName();
     * ```
     *
     * ---
     *
     * Returns the last name of the registration.
     *
     * @return string The last name.
     *
     * Example:
     * ```php
     * $lastName = $eventRegistration->getLastName();
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
     * Gibt den vollständigen Namen der Registrierung zurück.
     *
     * @param bool $reverse Wenn true, wird der Nachname vor dem Vornamen angezeigt.
     * @return string Der vollständige Name.
     *
     * Beispiel:
     * ```php
     * $name = $eventRegistration->getName(true);
     * ```
     *
     * ---
     *
     * Returns the full name of the registration.
     *
     * @param bool $reverse If true, the last name is displayed before the first name.
     * @return string The full name.
     *
     * Example:
     * ```php
     * $name = $eventRegistration->getName(true);
     * ```
     */
    public function getName(bool $reverse = false): string
    {
        $name = [];
        if ($this->getSalutation() !== "") {
            $name[] = $this->getSalutation();
        }
        if ($reverse) {
            $name[] = $this->getLastName() . ",";
            $name[] = $this->getFirstName();
            return implode(",", $name);
        }
        if (!$reverse) {
            $name[] = $this->getFirstName();
            $name[] = $this->getLastName();
            return implode(" ", $name);
        }
    }

    /**
     * Gibt die E-Mail-Adresse der Registrierung zurück.
     *
     * @return string Die E-Mail-Adresse.
     *
     * Beispiel:
     * ```php
     * $email = $eventRegistration->getEmail();
     * ```
     *
     * ---
     *
     * Returns the email address of the registration.
     *
     * @return string The email address.
     *
     * Example:
     * ```php
     * $email = $eventRegistration->getEmail();
     * ```
     */
    public function getEmail(): string
    {
        return $this->getValue('email');
    }
    public function setEmail(string $email): self
    {
        $this->setValue('email', $email);
        return $this;
    }

    /**
     * Gibt die Straße der Registrierung zurück.
     *
     * @return string Die Straße.
     *
     * Beispiel:
     * ```php
     * $street = $eventRegistration->getStreet();
     * ```
     *
     * ---
     *
     * Returns the street of the registration.
     *
     * @return string The street.
     *
     * Example:
     * ```php
     * $street = $eventRegistration->getStreet();
     * ```
     */
    public function getStreet(): string
    {
        return $this->getValue('street');
    }
    public function setStreet(string $street): self
    {
        $this->setValue('street', $street);
        return $this;
    }

    /**
     * Gibt die Postleitzahl der Registrierung zurück.
     *
     * @return string Die Postleitzahl.
     *
     * Beispiel:
     * ```php
     * $postalCode = $eventRegistration->getPostalCode();
     * ```
     *
     * ---
     *
     * Returns the postal code of the registration.
     *
     * @return string The postal code.
     *
     * Example:
     * ```php
     * $postalCode = $eventRegistration->getPostalCode();
     * ```
     */
    public function getPostalCode(): string
    {
        return $this->getValue('zip');
    }
    public function setPostalCode(string $postalCode): self
    {
        $this->setValue('zip', $postalCode);
        return $this;
    }

    /**
     * Gibt die Postleitzahl der Registrierung zurück.
     *
     * @return string Die Postleitzahl.
     *
     * Beispiel:
     * ```php
     * $zip = $eventRegistration->getZip();
     * ```
     *
     * ---
     *
     * Returns the zip code of the registration.
     *
     * @return string The zip code.
     *
     * Example:
     * ```php
     * $zip = $eventRegistration->getZip();
     * ```
     */
    public function getZip(): string
    {
        return $this->getValue('zip');
    }
    public function setZip(string $zip): self
    {
        $this->setValue('zip', $zip);
        return $this;
    }

    /**
     * Gibt die Stadt der Registrierung zurück.
     *
     * @return string Die Stadt.
     *
     * Beispiel:
     * ```php
     * $city = $eventRegistration->getCity();
     * ```
     *
     * ---
     *
     * Returns the city of the registration.
     *
     * @return string The city.
     *
     * Example:
     * ```php
     * $city = $eventRegistration->getCity();
     * ```
     */
    public function getCity(): string
    {
        return $this->getValue('city');
    }
    public function setCity(string $city): self
    {
        $this->setValue('city', $city);
        return $this;
    }
    /**
     * Gibt die Telefonnummer der Registrierung zurück.
     *
     * @return string Die Telefonnummer.
     *
     * Beispiel:
     * ```php
     * $phone = $eventRegistration->getPhone();
     * ```
     *
     * ---
     *
     * Returns the phone number of the registration.
     *
     * @return string The phone number.
     *
     * Example:
     * ```php
     * $phone = $eventRegistration->getPhone();
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
     * Gibt das Geburtsdatum der Registrierung zurück.
     *
     * @return string Das Geburtsdatum.
     *
     * Beispiel:
     * ```php
     * $birthday = $eventRegistration->getBirthday();
     * ```
     *
     * ---
     *
     * Returns the birthday of the registration.
     *
     * @return string The birthday.
     *
     * Example:
     * ```php
     * $birthday = $eventRegistration->getBirthday();
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
     * Gibt das formatierte Geburtsdatum der Registrierung zurück.
     *
     * @param string $format Das Datumsformat. Standard ist "Y-m-d H:i:s".
     * @return string Das formatierte Geburtsdatum.
     *
     * Beispiel:
     * ```php
     * $formattedBirthday = $eventRegistration->getBirthdayFormatted("d.m.Y");
     * ```
     *
     * ---
     *
     * Returns the formatted birthday of the registration.
     *
     * @param string $format The date format. Default is "Y-m-d H:i:s".
     * @return string The formatted birthday.
     *
     * Example:
     * ```php
     * $formattedBirthday = $eventRegistration->getBirthdayFormatted("d.m.Y");
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
     * Gibt die Zahlungsart der Registrierung zurück.
     *
     * @return string Die Zahlungsart.
     *
     * Beispiel:
     * ```php
     * $payment = $eventRegistration->getPayment();
     * ```
     *
     * ---
     *
     * Returns the payment method of the registration.
     *
     * @return string The payment method.
     *
     * Example:
     * ```php
     * $payment = $eventRegistration->getPayment();
     * ```
     */
    public function getPayment(): string
    {
        return $this->getValue('payment');
    }
    public function setPayment(string $payment): self
    {
        $this->setValue('payment', $payment);
        return $this;
    }
    /**
     * Gibt die Nachricht der Registrierung zurück.
     *
     * @return string Die Nachricht.
     *
     * Beispiel:
     * ```php
     * $message = $eventRegistration->getMessage();
     * ```
     *
     * ---
     *
     * Returns the message of the registration.
     *
     * @return string The message.
     *
     * Example:
     * ```php
     * $message = $eventRegistration->getMessage();
     * ```
     */
    public function getMessage(): string
    {
        return $this->getValue('message');
    }
    public function setMessage(string $message): self
    {
        $this->setValue('message', $message);
        return $this;
    }

    /**
     * Gibt den Kanal der Registrierung zurück.
     *
     * @return string Der Kanal.
     *
     * Beispiel:
     * ```php
     * $channel = $eventRegistration->getChannel();
     * ```
     *
     * ---
     *
     * Returns the channel of the registration.
     *
     * @return string The channel.
     *
     * Example:
     * ```php
     * $channel = $eventRegistration->getChannel();
     * ```
     */
    public function getChannel(): string
    {
        return $this->getValue('channel');
    }
    public function setChannel(string $channel): self
    {
        $this->setValue('channel', $channel);
        return $this;
    }

    /**
     * Gibt den Status der Registrierung zurück.
     *
     * @return int Der Status.
     *
     * Beispiel:
     * ```php
     * $status = $eventRegistration->getStatus();
     * ```
     *
     * ---
     *
     * Returns the status of the registration.
     *
     * @return int The status.
     *
     * Example:
     * ```php
     * $status = $eventRegistration->getStatus();
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
     * Gibt den Preis der Registrierung zurück.
     *
     * @return float Der Preis.
     *
     * Beispiel:
     * ```php
     * $price = $eventRegistration->getPrice();
     * ```
     *
     * ---
     *
     * Returns the price of the registration.
     *
     * @return float The price.
     *
     * Example:
     * ```php
     * $price = $eventRegistration->getPrice();
     * ```
     */
    public function getPrice(): float
    {
        return $this->getValue('price');
    }
    public function setPrice(float $price): self
    {
        $this->setValue('price', $price);
        return $this;
    }

    /**
     * Gibt die UUID der Registrierung zurück.
     *
     * @return string Die UUID.
     *
     * Beispiel:
     * ```php
     * $uuid = $eventRegistration->getUuid();
     * ```
     *
     * ---
     *
     * Returns the UUID of the registration.
     *
     * @return string The UUID.
     *
     * Example:
     * ```php
     * $uuid = $eventRegistration->getUuid();
     * ```
     */
    public function getUuid(): string
    {
        return $this->getValue('uuid');
    }
    public function setUuid(string $uuid): self
    {
        $this->setValue('uuid', $uuid);
        return $this;
    }

    /**
     * Gibt zurück, ob die Registrierung den Newsletter akzeptiert hat.
     *
     * @return bool Wahr, wenn der Newsletter akzeptiert wurde, sonst falsch.
     *
     * Beispiel:
     * ```php
     * $hasAcceptedNewsletter = $eventRegistration->hasAcceptedNewsletter();
     * ```
     *
     * ---
     *
     * Returns whether the registration has accepted the newsletter.
     *
     * @return bool True if the newsletter was accepted, otherwise false.
     *
     * Example:
     * ```php
     * $hasAcceptedNewsletter = $eventRegistration->hasAcceptedNewsletter();
     * ```
     */
    public function hasAcceptedNewsletter(): bool
    {
        return $this->getValue('newsletter');
    }
    /**
     * Gibt zurück, ob die Registrierung die AGB akzeptiert hat.
     *
     * @return bool Wahr, wenn die AGB akzeptiert wurden, sonst falsch.
     *
     * Beispiel:
     * ```php
     * $hasAcceptedAgb = $eventRegistration->hasAcceptedAgb();
     * ```
     *
     * ---
     *
     * Returns whether the registration has accepted the terms and conditions (AGB).
     *
     * @return bool True if the terms and conditions were accepted, otherwise false.
     *
     * Example:
     * ```php
     * $hasAcceptedAgb = $eventRegistration->hasAcceptedAgb();
     * ```
     */
    public function hasAcceptedAgb(): bool
    {
        return $this->getValue('agb');
    }

    /**
     * Gibt zurück, ob die Registrierung die Datenschutzrichtlinie akzeptiert hat.
     *
     * @return bool Wahr, wenn die Datenschutzrichtlinie akzeptiert wurde, sonst falsch.
     *
     * Beispiel:
     * ```php
     * $hasAcceptedPrivacyPolicy = $eventRegistration->hasAcceptedPrivacyPolicy();
     * ```
     *
     * ---
     *
     * Returns whether the registration has accepted the privacy policy.
     *
     * @return bool True if the privacy policy was accepted, otherwise false.
     *
     * Example:
     * ```php
     * $hasAcceptedPrivacyPolicy = $eventRegistration->hasAcceptedPrivacyPolicy();
     * ```
     */
    public function hasAcceptedPrivacyPolicy(): bool
    {
        return $this->getValue('dsgvo');
    }
    /**
     * Gibt die Registrierung mit der gegebenen UUID zurück.
     *
     * @param string $uuid Die UUID der Registrierung.
     * @return event_registration|null Die Registrierung oder null, wenn keine gefunden wurde.
     *
     * Beispiel:
     * ```php
     * $registration = event_registration::getByUuid($uuid);
     * ```
     *
     * ---
     *
     * Returns the registration with the given UUID.
     *
     * @param string $uuid The UUID of the registration.
     * @return event_registration|null The registration or null if none was found.
     *
     * Example:
     * ```php
     * $registration = event_registration::getByUuid($uuid);
     * ```
     */
    public static function getByUuid(string $uuid = null): ?event_registration
    {
        if (!$uuid) {
            return null;
        }
        return self::query()->where('uuid', $uuid)->findOne();
    }

    /**
     * Gibt den Hash der Registrierung zurück.
     *
     * @return string Der Hash.
     *
     * Beispiel:
     * ```php
     * $hash = $eventRegistration->getHash();
     * ```
     *
     * ---
     *
     * Returns the hash of the registration.
     *
     * @return string The hash.
     *
     * Example:
     * ```php
     * $hash = $eventRegistration->getHash();
     * ```
     */
    public function getHash(): string
    {
        return $this->getValue('hash');
    }

    /**
     * Gibt die Registrierung mit dem gegebenen Hash zurück.
     *
     * @param string $hash Der Hash der Registrierung.
     * @return event_registration|null Die Registrierung oder null, wenn keine gefunden wurde.
     *
     * Beispiel:
     * ```php
     * $registration = event_registration::getByHash($hash);
     * ```
     *
     * ---
     *
     * Returns the registration with the given hash.
     *
     * @param string $hash The hash of the registration.
     * @return event_registration|null The registration or null if none was found.
     *
     * Example:
     * ```php
     * $registration = event_registration::getByHash($hash);
     * ```
     */
    public static function getByHash(string $hash = null): ?event_registration
    {
        if (!$hash) {
            return null;
        }
        return self::query()->where('hash', $hash)->findOne();
    }
}
