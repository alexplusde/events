<?php
/**
 * Die `event_date_offer` Klasse repräsentiert ein Angebot für ein bestimmtes Event-Datum.
 *
 * Sie erbt von der `rex_yform_manager_dataset` Klasse und bietet zusätzliche Methoden
 * zur Interaktion mit den Angeboten eines Event-Datums.
 *
 * Beispiel:
 * ```php
 * // Erstellt ein neues Angebot für ein Event-Datum
 * $offer = new event_date_offer();
 * $offer->setValue('event_date_id', $eventDateId);
 * $offer->setValue('offer', 'Spezielles Angebot');
 * $offer->save();
 * ```
 *
 * ---
 *
 * The `event_date_offer` class represents an offer for a specific event date.
 *
 * It inherits from the `rex_yform_manager_dataset` class and provides additional methods
 * for interacting with the offers of an event date.
 *
 * Example:
 * ```php
 * // Creates a new offer for an event date
 * $offer = new event_date_offer();
 * $offer->setValue('event_date_id', $eventDateId);
 * $offer->setValue('offer', 'Special Offer');
 * $offer->save();
 * ```
 */
class event_date_offer extends \rex_yform_manager_dataset
{
    /**
     * Gibt die URL des Angebots zurück.
     *
     * @return string Die URL des Angebots.
     *
     * Beispiel:
     * ```php
     * $url = $offer->getUrl();
     * ```
     *
     * ---
     *
     * Returns the URL of the offer.
     *
     * @return string The URL of the offer.
     *
     * Example:
     * ```php
     * $url = $offer->getUrl();
     * ```
     */
    public function getUrl(): string
    {
        return $this->getValue('url');
    }

    /**
     * Gibt den Status des Angebots zurück.
     *
     * @return string Der Status des Angebots.
     *
     * Beispiel:
     * ```php
     * $status = $offer->getStatus();
     * ```
     *
     * ---
     *
     * Returns the status of the offer.
     *
     * @return string The status of the offer.
     *
     * Example:
     * ```php
     * $status = $offer->getStatus();
     * ```
     */
    public function getStatus(): string
    {
        return $this->getValue('status');
    }

    /**
     * Gibt den Preis des Angebots zurück.
     *
     * @return string Der Preis des Angebots.
     *
     * Beispiel:
     * ```php
     * $price = $offer->getPrice();
     * ```
     *
     * ---
     *
     * Returns the price of the offer.
     *
     * @return string The price of the offer.
     *
     * Example:
     * ```php
     * $price = $offer->getPrice();
     * ```
     */
    public function getPrice(): string
    {
        return $this->getValue('price');
    }
    
    /**
     * Gibt die Währung des Angebots zurück.
     *
     * @return string Die Währung des Angebots.
     *
     * Beispiel:
     * ```php
     * $currency = $offer->getCurrency();
     * ```
     *
     * ---
     *
     * Returns the currency of the offer.
     *
     * @return string The currency of the offer.
     *
     * Example:
     * ```php
     * $currency = $offer->getCurrency();
     * ```
     */
    public function getCurrency() :string
    {
        return $this->getValue('currency') ?? rex_config::get('events', 'currency');
    }

    /**
     * Gibt den formatierten Preis des Angebots zurück.
     *
     * @return string Der formatierte Preis des Angebots.
     *
     * Beispiel:
     * ```php
     * $priceFormatted = $offer->getPriceFormatted();
     * ```
     *
     * ---
     *
     * Returns the formatted price of the offer.
     *
     * @return string The formatted price of the offer.
     *
     * Example:
     * ```php
     * $priceFormatted = $offer->getPriceFormatted();
     * ```
     */
    public function getPriceFormatted() :string
    {
        return number_format($this->getValue('price'), 2, ',', '.') . " " . $this->getCurrency();
    }
    /**
     * Gibt die Verfügbarkeit des Angebots als schema.org kompatiblen Wert zurück.
     *
     * @return string Die Verfügbarkeit des Angebots.
     *
     * Beispiel:
     * ```php
     * $availability = $offer->getAvailability();
     * ```
     *
     * ---
     *
     * Returns the availability of the offer as schema.org compatible value.
     *
     * @return string The availability of the offer.
     *
     * Example:
     * ```php
     * $availability = $offer->getAvailability();
     * ```
     */
    public function getAvailability() :string
    {
        return "https://schema.org/" . $this->getValue('status');
    }
}
