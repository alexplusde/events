<?php
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
class event_location extends \rex_yform_manager_dataset
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
}
