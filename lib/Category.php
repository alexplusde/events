<?php

namespace Alexplusde\Events;

use rex_media;
use rex_yform_manager_collection;
use rex_user;


/**
 * Die Klasse event_category repräsentiert eine Kategorie eines Events.
 *
 * Diese Klasse erweitert die rex_yform_manager_dataset Klasse und stellt spezifische Funktionen
 * und Eigenschaften zur Verfügung, die für die Verwaltung von Event-Kategorien notwendig sind.
 *
 * Beispiel:
 * ```php
 * $eventCategory = new Category();
 * ```
 *
 * ---
 *
 * The event_category class represents a category of an event.
 *
 * This class extends the rex_yform_manager_dataset class and provides specific functions
 * and properties that are necessary for managing event categories.
 *
 * Example:
 * ```php
 * $eventCategory = new Category();
 * ```
 */
class Category extends \rex_yform_manager_dataset
{

    const STATUS_ONLINE = 1;
    const STATUS_OFFLINE = 0;

    /**
     * Gibt den Namen der Kategorie zurück.
     *
     * @return string Der Name der Kategorie.
     *
     * Beispiel:
     * ```php
     * $name = $eventCategory->getName();
     * ```
     *
     * ---
     *
     * Returns the name of the category.
     *
     * @return string The name of the category.
     *
     * Example:
     * ```php
     * $name = $eventCategory->getName();
     * ```
     */

    public function getName() : ?string {
        return $this->getValue("name");
    }
    /** @api */
    public function setName(mixed $value) : self {
        $this->setValue("name", $value);
        return $this;
    }
    /**
     * Gibt das Bild der Kategorie zurück.
     *
     * @return string Das Bild der Kategorie.
     *
     * Beispiel:
     * ```php
     * $image = $eventCategory->getImage();
     * ```
     *
     * ---
     *
     * Returns the image of the category.
     *
     * @return string The image of the category.
     *
     * Example:
     * ```php
     * $image = $eventCategory->getImage();
     * ```
     */
    public function getImage(): string
    {
        return $this->image;
    }
    public function setImage(string $image): self
    {
        $this->setValue('image', $image);
        return $this;
    }

    /**
     * Gibt das rex_media Objekt des Bildes zurück.
     *
     * @return rex_media Das rex_media Objekt des Bildes.
     *
     * Beispiel:
     * ```php
     * $media = $eventCategory->getMedia();
     * ```
     *
     * ---
     *
     * Returns the rex_media object of the image.
     *
     * @return rex_media The rex_media object of the image.
     *
     * Example:
     * ```php
     * $media = $eventCategory->getMedia();
     * ```
     */
    public function getMedia(): rex_media
    {
        return rex_media::get($this->image);
    }
    /**
     * Gibt das Icon der Kategorie zurück.
     *
     * @return string Das Icon der Kategorie.
     *
     * Beispiel:
     * ```php
     * $icon = $eventCategory->getIcon();
     * ```
     *
     * ---
     *
     * Returns the icon of the category.
     *
     * @return string The icon of the category.
     *
     * Example:
     * ```php
     * $icon = $eventCategory->getIcon();
     * ```
     */
    /** @api */
    public function getIcon() : ?string {
        return $this->getValue("icon");
    }
    /** @api */
    public function setIcon(mixed $value) : self {
        $this->setValue("icon", $value);
        return $this;
    }
    /**
     * Gibt den Preis der Kategorie zurück.
     *
     * @return string Der Preis der Kategorie.
     *
     * Beispiel:
     * ```php
     * $price = $eventCategory->getPrice();
     * ```
     *
     * ---
     *
     * Returns the price of the category.
     *
     * @return string The price of the category.
     *
     * Example:
     * ```php
     * $price = $eventCategory->getPrice();
     * ```
     */
    public function getPrice(): string
    {
        return $this->getValue('msg_price');
    }
    public function setPrice(string $price): self
    {
        $this->setValue('msg_price', $price);
        return $this;
    }

    /**
     * Gibt die URL der Kategorie zurück.
     *
     * @return string Die URL der Kategorie.
     *
     * Beispiel:
     * ```php
     * $url = $eventCategory->getUrl();
     * ```
     *
     * ---
     *
     * Returns the URL of the category.
     *
     * @return string The URL of the category.
     *
     * Example:
     * ```php
     * $url = $eventCategory->getUrl();
     * ```
     */
    public function getUrl(): string
    {
        return rex_getUrl('', '', ['event-category-id' => $this->getId()]);
    }
    public function setUrl(string $url): self
    {
        $this->setValue('url', $url);
        return $this;
    }

    /**
     * Gibt eine Sammlung von Event-Daten zurück, die auf einem bestimmten Kriterium basieren.
     *
     * @param string $whereRaw Das Kriterium, auf dem die Event-Daten basieren sollen.
     * @return rex_yform_manager_collection|null Eine Sammlung von Event-Daten oder null.
     *
     * Beispiel:
     * ```php
     * $dates = $eventCategory->getDateWhere('startDate > NOW()');
     * ```
     *
     * ---
     *
     * Returns a collection of event dates based on a certain criterion.
     *
     * @param string $whereRaw The criterion that the event dates should be based on.
     * @return rex_yform_manager_collection|null A collection of event dates or null.
     *
     * Example:
     * ```php
     * $dates = $eventCategory->getDateWhere('startDate > NOW()');
     * ```
     */
    public function getDateWhere($whereRaw = ''): ?rex_yform_manager_collection
    {
        return Date::query()->joinRelation('category_id', 'c')->where('c.id', $this->getId())->whereRaw($whereRaw)->orderBy('startDate', 'ASC')->orderBy('startTime', "ASC")->find();
    }

    /**
     * Gibt eine Sammlung von verwandten Event-Daten zurück.
     *
     * @param string $whereRaw Das Kriterium, auf dem die verwandten Event-Daten basieren sollen.
     * @return rex_yform_manager_collection|null Eine Sammlung von verwandten Event-Daten oder null.
     *
     * Beispiel:
     * ```php
     * $relatedDates = $eventCategory->getRelatedDates('startDate > NOW()');
     * ```
     *
     * ---
     *
     * Returns a collection of related event dates.
     *
     * @param string $whereRaw The criterion that the related event dates should be based on.
     * @return rex_yform_manager_collection|null A collection of related event dates or null.
     *
     * Example:
     * ```php
     * $relatedDates = $eventCategory->getRelatedDates('startDate > NOW()');
     * ```
     */
    public function getRelatedDates($whereRaw = ''): ?rex_yform_manager_collection
    {
        return $this->getDateWhere($whereRaw);
    }
    public function setRelatedDates(rex_yform_manager_collection $relatedDates): self
    {
        $this->relatedDates = $relatedDates;
        return $this;
    }
    /**
     * Gibt ein Array von Attributen zurück.
     *
     * @return array Ein Array von Attributen.
     *
     * Beispiel:
     * ```php
     * $attributes = $eventCategory->getAttributes();
     * ```
     *
     * ---
     *
     * Returns an array of attributes.
     *
     * @return array An array of attributes.
     *
     * Example:
     * ```php
     * $attributes = $eventCategory->getAttributes();
     * ```
     */

    /* Teaser */
    /** @api */
    public function getTeaser(bool $asPlaintext = false) : ?string {
        if($asPlaintext) {
            return strip_tags($this->getValue("teaser"));
        }
        return $this->getValue("teaser");
    }
    /** @api */
    public function setTeaser(mixed $value) : self {
        $this->setValue("teaser", $value);
        return $this;
    }
            
    /* Beschreibung */
    /** @api */
    public function getDescription(bool $asPlaintext = false) : ?string {
        if($asPlaintext) {
            return strip_tags($this->getValue("description"));
        }
        return $this->getValue("description");
    }
    /** @api */
    public function setDescription(mixed $value) : self {
        $this->setValue("description", $value);
        return $this;
    }
            
    /* Bilder */
    /** @api */
    public function getImages() : array {

        return explode(",", $this->getValue("images"));
    }
    /** @api */
    public function setImages(array|string $filename) : self {
        if(is_array($filename)) {
            $this->getValue("images", implode(",",$filename));
        } else {
            $this->setValue("images", $filename);
        }
        return $this;
    }
            
    /* Status */
    /** @api */
    public function getStatus() : mixed {
        return $this->getValue("status");
    }
    /** @api */
    public function setStatus(mixed $param) : mixed {
        $this->setValue("status", $param);
        return $this;
    }

    /* Termin(e) */
    /** @api */
    public function getDate() : ?rex_yform_manager_collection {
        return $this->getRelatedCollection("date_id");
    }

    /* Erstellt von... */
    /** @api */
    public function getCreateUser() : ?rex_user {
        return rex_user::get($this->getValue("createuser"));
    }
    /** @api */
    public function setCreateUser(mixed $value) : self {
        $this->setValue("createuser", $value);
        return $this;
    }

    /* Zuletzt geändert von... */
    /** @api */
    public function getUpdateUser() : ?rex_user {
        return rex_user::get($this->getValue("updateuser"));
    }
    /** @api */
    public function setUpdateUser(mixed $value) : self {
        $this->setValue("updateuser", $value);
        return $this;
    }

    public static function getStatusOptions() : array {
        return [
            self::STATUS_ONLINE => \rex_i18n::msg('events_category_status_online'),
            self::STATUS_OFFLINE => \rex_i18n::msg('events_category_status_offline')
        ];
    }

}?>
