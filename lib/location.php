<?php 

namespace Alexplusde\Events;

use rex_yform_manager_dataset;
use rex_yform_manager_collection;
use rex_user;

/**
 * Die `event_location` Klasse repräsentiert einen Veranstaltungsort.
 *
 * Sie erbt von der `rex_yform_manager_dataset` Klasse und bietet zusätzliche Methoden
 * zur Interaktion mit den Veranstaltungsorten.
 *
 * Beispiel:
 * ```php
 * // Erstellt einen neuen Veranstaltungsort
 * $location = new event_location();
 * $location->setValue('name', 'Konzerthalle');
 * $location->save();
 * ```
 *
 * ---
 *
 * The `event_location` class represents an event location.
 *
 * It inherits from the `rex_yform_manager_dataset` class and provides additional methods
 * for interacting with the event locations.
 *
 * Example:
 * ```php
 * // Creates a new event location
 * $location = new event_location();
 * $location->setValue('name', 'Concert Hall');
 * $location->save();
 * ```
 */
class Location extends \rex_yform_manager_dataset
{
    /**
     * Gibt die Adresse als String zurück.
     *
     * @return string Die Adresse als String.
     *
     * Beispiel:
     * ```php
     * $addressString = $location->getAsString();
     * ```
     *
     * ---
     *
     * Returns the address as a string.
     *
     * @return string The address as a string.
     *
     * Example:
     * ```php
     * $addressString = $location->getAsString();
     * ```
     */
    public function getAsString() :string
    {
        return $this->getValue('street') .", ". $this->getValue('zip') .", ".$this->getValue('locality').", ".$this->getValue('countrycode');
    }
    public function setAsString(string $addressString) :self
    {
        $address = explode(',', $addressString);
        $this->setValue('street', $address[0]);
        $this->setValue('zip', $address[1]);
        $this->setValue('locality', $address[2]);
        $this->setValue('countrycode', $address[3]);
        return $this;
    }

    /**
     * Gibt die formatierte Adresse zurück.
     *
     * @return string Die formatierte Adresse.
     *
     * Beispiel:
     * ```php
     * $formattedAddress = $location->getFormattedAddress();
     * ```
     *
     * ---
     *
     * Returns the formatted address.
     *
     * @return string The formatted address.
     *
     * Example:
     * ```php
     * $formattedAddress = $location->getFormattedAddress();
     * ```
     */
    public function getFormattedAddress() :string
    {
        return $this->getValue('street') .", ". $this->getValue('zip') ." ".$this->getValue('locality');
    }

    /**
     * Gibt den Namen des Veranstaltungsorts zurück.
     *
     * @return string Der Name des Veranstaltungsorts.
     *
     * Beispiel:
     * ```php
     * $name = $location->getName();
     * ```
     *
     * ---
     *
     * Returns the name of the event location.
     *
     * @return string The name of the event location.
     *
     * Example:
     * ```php
     * $name = $location->getName();
     * ```
     */
    public function getName() :string
    {
        return $this->getValue('name');
    }
    public function setName(string $name) :self
    {
        $this->setValue('name', $name);
        return $this;
    }

    /**
     * Gibt die Straße des Veranstaltungsorts zurück.
     *
     * @return string Die Straße des Veranstaltungsorts.
     *
     * Beispiel:
     * ```php
     * $street = $location->getStreet();
     * ```
     *
     * ---
     *
     * Returns the street of the event location.
     *
     * @return string The street of the event location.
     *
     * Example:
     * ```php
     * $street = $location->getStreet();
     * ```
     */
    public function getStreet() :string
    {
        return $this->getValue('street');
    }
    public function setStreet(string $street) :self
    {
        $this->setValue('street', $street);
        return $this;
    }
    
    /**
     * Gibt die Postleitzahl des Veranstaltungsorts zurück.
     *
     * @return string Die Postleitzahl des Veranstaltungsorts.
     *
     * Beispiel:
     * ```php
     * $zip = $location->getZip();
     * ```
     *
     * ---
     *
     * Returns the zip code of the event location.
     *
     * @return string The zip code of the event location.
     *
     * Example:
     * ```php
     * $zip = $location->getZip();
     * ```
     */
    public function getZip() :string
    {
        return $this->getValue('zip');
    }
    public function setZip(string $zip) :self
    {
        $this->setValue('zip', $zip);
        return $this;
    }

    /**
     * Gibt die Ortschaft des Veranstaltungsorts zurück.
     *
     * @return string Die Ortschaft des Veranstaltungsorts.
     *
     * Beispiel:
     * ```php
     * $locality = $location->getLocality();
     * ```
     *
     * ---
     *
     * Returns the locality of the event location.
     *
     * @return string The locality of the event location.
     *
     * Example:
     * ```php
     * $locality = $location->getLocality();
     * ```
     */
    public function getLocality() :string
    {
        return $this->getValue('locality');
    }
    public function setLocality(string $locality) :self
    {
        $this->setValue('locality', $locality);
        return $this;
    }

    /**
     * Gibt die Stadt des Veranstaltungsorts zurück.
     *
     * @return string Die Stadt des Veranstaltungsorts.
     *
     * Beispiel:
     * ```php
     * $city = $location->getCity();
     * ```
     *
     * ---
     *
     * Returns the city of the event location.
     *
     * @return string The city of the event location.
     *
     * Example:
     * ```php
     * $city = $location->getCity();
     * ```
     */
    public function getCity() :string
    {
        return $this->getLocality();
    }
    public function setCity(string $city) :self
    {
        $this->setLocality($city);
        return $this;
    }
    /**
     * Gibt den Ländercode des Veranstaltungsorts zurück.
     *
     * @return string Der Ländercode des Veranstaltungsorts.
     *
     * Beispiel:
     * ```php
     * $countryCode = $location->getCountryCode();
     * ```
     *
     * ---
     *
     * Returns the country code of the event location.
     *
     * @return string The country code of the event location.
     *
     * Example:
     * ```php
     * $countryCode = $location->getCountryCode();
     * ```
     */
    public function getCountryCode() :string
    {
        return $this->getValue('countrycode');
    }
    public function setCountryCode(string $countryCode) :self
    {
        $this->setValue('countrycode', $countryCode);
        return $this;
    }

    /**
     * Gibt die geographischen Koordinaten des Veranstaltungsorts zurück.
     *
     * @return string Die geographischen Koordinaten des Veranstaltungsorts.
     *
     * Beispiel:
     * ```php
     * $latLng = $location->getLatLng();
     * ```
     *
     * ---
     *
     * Returns the geographical coordinates of the event location.
     *
     * @return string The geographical coordinates of the event location.
     *
     * Example:
     * ```php
     * $latLng = $location->getLatLng();
     * ```
     */
    public function getLatLng() :string
    {
        return $this->getValue('lat_lng');
    }
    public function setLatLng(string $latLng) :self
    {
        $this->setValue('lat_lng', $latLng);
        return $this;
    }
    /**
     * Gibt den Breitengrad des Veranstaltungsorts zurück.
     *
     * @return string Der Breitengrad des Veranstaltungsorts.
     *
     * Beispiel:
     * ```php
     * $lat = $location->getLat();
     * ```
     *
     * ---
     *
     * Returns the latitude of the event location.
     *
     * @return string The latitude of the event location.
     *
     * Example:
     * ```php
     * $lat = $location->getLat();
     * ```
     */
    public function getLat() :string
    {
        return $this->getValue('lat');
    }
    public function setLat(string $lat) :self
    {
        $this->setValue('lat', $lat);
        return $this;
    }

    /**
     * Gibt den Längengrad des Veranstaltungsorts zurück.
     *
     * @return string Der Längengrad des Veranstaltungsorts.
     *
     * Beispiel:
     * ```php
     * $lng = $location->getLng();
     * ```
     *
     * ---
     *
     * Returns the longitude of the event location.
     *
     * @return string The longitude of the event location.
     *
     * Example:
     * ```php
     * $lng = $location->getLng();
     * ```
     */
    public function getLng() :string
    {
        return $this->getValue('lng');
    }
    public function setLng(string $lng) :self
    {
        $this->setValue('lng', $lng);
        return $this;
    }

    /* Google Places */
    /** @api */
    public function getGooglePlaces() : ?string {
        return $this->getValue("google_places");
    }
    /** @api */
    public function setGooglePlaces(mixed $value) : self {
        $this->setValue("google_places", $value);
        return $this;
    }

    /* Kategorie */
    /** @api */
    public function getLocationCategory() : ?rex_yform_manager_dataset {
        return $this->getRelatedDataset("location_category_id");
    }

    /* Aktualisierert von... */
    /** @api */
    public function getUpdateuser() : ?rex_user {
        return rex_user::get($this->getValue("updateuser"));
    }
    /** @api */
    public function setUpdateuser(mixed $value) : self {
        $this->setValue("updateuser", $value);
        return $this;
    }

    /* Erstellt von... */
    /** @api */
    public function getCreateuser() : ?rex_user {
        return rex_user::get($this->getValue("createuser"));
    }
    /** @api */
    public function setCreateuser(mixed $value) : self {
        $this->setValue("createuser", $value);
        return $this;
    }

    /* Aktualisiert am... */
    /** @api */
    public function getUpdatedate() : ?string {
        return $this->getValue("updatedate");
    }
    /** @api */
    public function setUpdatedate(string $value) : self {
        $this->setValue("updatedate", $value);
        return $this;
    }

    /* Erstellt am... */
    /** @api */
    public function getCreatedate() : ?string {
        return $this->getValue("createdate");
    }
    /** @api */
    public function setCreatedate(string $value) : self {
        $this->setValue("createdate", $value);
        return $this;
    }

}
