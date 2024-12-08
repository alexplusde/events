<?php

namespace Alexplusde\Events;

use Ramsey\uuid\uuid;
use rex;
use rex_media;
use rex_yform_manager_collection;
use rex_yform_manager_dataset;
use rex_yform_manager_table;
use rex_clang;
use rex_sql;
use rex_user;
use rex_fragment;
use IntlDateFormatter;
use DateTime;
use rex_config;
use rex_i18n;

/**
* Die `event_date` Klasse repräsentiert ein Event-Datum.
* Diese Klasse erweitert die `rex_yform_manager_dataset` Klasse und bietet spezifische Funktionen und Eigenschaften, die für die Verwaltung von Event-Daten notwendig sind.
*
* Beispiel:
* ```php
* $eventDate = new Date();
* $eventDate->setValue('startDate', '2022-12-31');
* $eventDate->setValue('endDate', '2023-01-01');
* $eventDate->save();
* ```
*
* ---
*
* The `event_date` class represents an event date.
* This class extends the `rex_yform_manager_dataset` class and provides specific functions and properties necessary for managing event dates.
*
* Example:
* ```php
* $eventDate = new Date();
* $eventDate->setValue('startDate', '2022-12-31');
* $eventDate->setValue('endDate', '2023-01-01');
* $eventDate->save();
* ```
*/
class Date extends \rex_yform_manager_dataset
{
    private ?Location $location = null;
    private ?Category $category = null;
    private ?Offer $offer = null;

    const STATUS_EVENT_CANCELLED = "EventCancelled";
    const STATUS_EVENT_MOVED_ONLINE = "EventMovedOnline";
    const STATUS_EVENT_POSTPONED = "EventPostponed";
    const STATUS_EVENT_RESCHEDULED = "EventRescheduled";
    const STATUS_EVENT_SCHEDULED = "EventScheduled";

    /**
    * Generiert eine UUID basierend auf der gegebenen ID.
    *
    * @param mixed $id Die ID, auf der die UUID basieren soll.
    * @return string Die generierte UUID.
    *
    * Beispiel:
    * ```php
    * $uuid = event_date::generateuuid(123);
    * ```
    *
    * ---
    *
    * Generates a UUID based on the given ID.
    *
    * @param mixed $id The ID that the UUID should be based on.
    * @return string The generated UUID.
    *
    * Example:
    * ```php
    * $uuid = event_date::generateuuid(123);
    * ```
    */
    public static function generateuuid($id = null) :string
    {
        return uuid::uuid3(uuid::NAMESPACE_URL, $id);
    }

    /**
    * Gibt die Kategorie des Events zurück.
    *
    * @return Category|null Die Kategorie des Events oder null.
    *
    * Beispiel:
    * ```php
    * $category = $eventDate->getCategory();
    * ```
    *
    * ---
    *
    * Returns the category of the event.
    *
    * @return Category|null The category of the event or null.
    *
    * Example:
    * ```php
    * $category = $eventDate->getCategory();
    * ```
    */
    public function getCategory(): ?Category
    {
        $this->category = Category::get((int)$this->getValue('event_category_id'));
        return $this->category;
    }

    /**
    * Gibt eine Sammlung von Kategorien zurück, die mit dem Event verbunden sind.
    *
    * @return rex_yform_manager_collection Eine Sammlung von Kategorien.
    *
    * Beispiel:
    * ```php
    * $categories = $eventDate->getCategories();
    * ```
    *
    * ---
    *
    * Returns a collection of categories associated with the event.
    *
    * @return rex_yform_manager_collection A collection of categories.
    *
    * Example:
    * ```php
    * $categories = $eventDate->getCategories();
    * ```
    */
    public function getCategories(): rex_yform_manager_collection
    {
        $this->categories = $this->getRelatedCollection('event_category_id');
        return $this->categories;
    }
    /**
    * Gibt eine iCalendar-Repräsentation des Events zurück.
    *
    * Diese Methode erstellt eine iCalendar-Repräsentation des Events, die dann zum Beispiel in Kalenderanwendungen importiert werden kann.
    *
    * @return string Die iCalendar-Repräsentation des Events.
    *
    * Beispiel:
    * ```php
    * $ics = $eventDate->getIcs();
    * ```
    *
    * ---
    *
    * Returns an iCalendar representation of the event.
    *
    * This method creates an iCalendar representation of the event, which can then be imported into calendar applications, for example.
    *
    * @return string The iCalendar representation of the event.
    *
    * Example:
    * ```php
    * $ics = $eventDate->getIcs();
    * ```
    */
    public function getIcs(): string
    {
        $UID = $this->getUid();

        $vCalendar = new \Eluceo\iCal\Component\Calendar('-//' . date("Y") . '//#' . rex::getServerName() . '//' . strtoupper((rex_clang::getCurrent())->getCode()));
        date_default_timezone_set(rex::getProperty('timezone'));

        $vEvent = new \Eluceo\iCal\Component\Event($UID);

        // date/time
        $vEvent
        ->setUseTimezone(true)
        ->setDtStart($this->getStartTime())
        ->setDtEnd($this->getEndTime())
        ->setCreated(new \DateTime($this->getValue("createdate")))
        ->setModified(new \DateTime($this->getValue("updatedate")))
        ->setNoTime($this->getValue("all_day"))
        // ->setNoTime($is_fulltime) // Wenn Ganztag
        // ->setCategories(explode(",", $sked['entry']->category_name))
        ->setSummary($this->getName())
        ->setDescription($this->getDescriptionAsPlaintext());

        // add location
        /* @var $locationICS Location */
        $location = $this->getLocation();
        if (isset($location)) {
            $ics_lat = $location->getValue('lat');
            $ics_lng = $location->getValue('lng');
            $vEvent->setLocation($location->getAsString(), $location->getValue('name'), $ics_lat != '' ? $ics_lat . ',' . $ics_lng : '');
            // fehlt: set timezone of location
        }

        //  add event to calendar
        $vCalendar->addComponent($vEvent);

        return $vCalendar->render();
        // ob_clean();

        // exit($vEvent);
    }
    /**
    * Gibt den Standort des Events zurück.
    *
    * @return Location|null Der Standort des Events oder null.
    *
    * Beispiel:
    * ```php
    * $location = $eventDate->getLocation();
    * ```
    *
    * ---
    *
    * Returns the location of the event.
    *
    * @return Location|null The location of the event or null.
    *
    * Example:
    * ```php
    * $location = $eventDate->getLocation();
    * ```
    */
    public function getLocation(): ?Location
    {
        if ($this->location === null) {
            $this->location = $this->getRelatedDataset('location');
        }
        return $this->location;
    }
    public function setLocation(Location $location): self
    {
        $this->location = $location;
        $this->setValue('location', $location->getId());
        return $this;
    }

    /**
    * Gibt die ID des Standorts zurück.
    *
    * @return int Die ID des Standorts.
    *
    * Beispiel:
    * ```php
    * $locationId = $eventDate->getLocationId();
    * ```
    *
    * ---
    *
    * Returns the ID of the location.
    *
    * @return int The ID of the location.
    *
    * Example:
    * ```php
    * $locationId = $eventDate->getLocationId();
    * ```
    */
    public function getLocationId(): int
    {
        return $this->getValue('location');
    }
    public function setLocationId(int $locationId): self
    {
        $this->setValue('location', $locationId);
        return $this;
    }
    /**
    * Gibt die Zeitzone basierend auf den gegebenen Koordinaten zurück.
    *
    * Diese Methode verwendet die Google Maps Timezone API, um die Zeitzone zu ermitteln.
    *
    * @param float $lat Der Breitengrad.
    * @param float $lng Der Längengrad.
    * @return string Die Zeitzone im JSON-Format.
    *
    * Beispiel:
    * ```php
    * $timezone = $eventDate->getTimezone(52.5200, 13.4050);
    * ```
    *
    * ---
    *
    * Returns the timezone based on the given coordinates.
    *
    * This method uses the Google Maps Timezone API to determine the timezone.
    *
    * @param float $lat The latitude.
    * @param float $lng The longitude.
    * @return string The timezone in JSON format.
    *
    * Example:
    * ```php
    * $timezone = $eventDate->getTimezone(52.5200, 13.4050);
    * ```
    */
    public function getTimezone(float $lat, float $lng): string
    {
        $event_timezone = "https://maps.googleapis.com/maps/api/timezone/json?location=" . $lat . "," . $lng . "&timestamp=" . time() . "&sensor=false";
        $Location_time_json = file_get_contents($event_timezone);
        return $Location_time_json;
    }
    public function setTimezone(string $timezone): self
    {
        $this->setValue('timezone', $timezone);
        return $this;
    }
    /**
    * Gibt eine Sammlung von Angeboten zurück, die mit dem Event verbunden sind.
    *
    * @return rex_yform_manager_collection|null Eine Sammlung von Angeboten oder null.
    *
    * Beispiel:
    * ```php
    * $offers = $eventDate->getOfferAll();
    * ```
    *
    * ---
    *
    * Returns a collection of offers associated with the event.
    *
    * @return rex_yform_manager_collection|null A collection of offers or null.
    *
    * Example:
    * ```php
    * $offers = $eventDate->getOfferAll();
    * ```
    */
    public function getOfferAll(): ?rex_yform_manager_collection
    {
        return $this->getRelatedCollection('offer');
    }
    
    /**
    * Gibt das Bild des Events zurück.
    *
    * @return string|null Das Bild des Events oder null.
    *
    * Beispiel:
    * ```php
    * $image = $eventDate->getImage();
    * ```
    *
    * ---
    *
    * Returns the image of the event.
    *
    * @return string|null The image of the event or null.
    *
    * Example:
    * ```php
    * $image = $eventDate->getImage();
    * ```
    */
    public function getImage(): ?string
    {
        return $this->image;
    }
    public function setImage(string $image): self
    {
        $this->image = $image;
        return $this;
    }

    /**
    * Gibt das Medienobjekt des Bildes zurück.
    *
    * @return rex_media Das Medienobjekt des Bildes.
    *
    * Beispiel:
    * ```php
    * $media = $eventDate->getMedia();
    * ```
    *
    * ---
    *
    * Returns the media object of the image.
    *
    * @return rex_media The media object of the image.
    *
    * Example:
    * ```php
    * $media = $eventDate->getMedia();
    * ```
    */
    public function getMedia(): rex_media
    {
        return rex_media::get($this->image);
    }
    /**
    * Gibt den ICS-Status des Events zurück.
    *
    * @return int Der ICS-Status des Events.
    *
    * Beispiel:
    * ```php
    * $icsStatus = $eventDate->getIcsStatus();
    * ```
    *
    * ---
    *
    * Returns the ICS status of the event.
    *
    * @return int The ICS status of the event.
    *
    * Example:
    * ```php
    * $icsStatus = $eventDate->getIcsStatus();
    * ```
    */
    public function getIcsStatus(): int
    {
        return strip_tags($this->getValue('eventStatus'));
    }
    public function setIcsStatus(int $icsStatus): self
    {
        $this->setValue('eventStatus', $icsStatus);
        return $this;
    }

    /**
    * Gibt die eindeutige ID (UID) des Events zurück.
    *
    * Wenn die UID noch nicht gesetzt wurde, wird sie generiert und in der Datenbank gespeichert.
    *
    * @return string Die UID des Events.
    *
    * Beispiel:
    * ```php
    * $uid = $eventDate->getUid();
    * ```
    *
    * ---
    *
    * Returns the unique ID (UID) of the event.
    *
    * If the UID has not been set yet, it is generated and stored in the database.
    *
    * @return string The UID of the event.
    *
    * Example:
    * ```php
    * $uid = $eventDate->getUid();
    * ```
    */
    public function getUid(): string
    {
        if ($this->uid === "" && $this->getValue("uid") === "") {
            $this->uid = self::generateUuid($this->id);

            rex_sql::factory()->setQuery("UPDATE rex_event_date SET uid = :uid WHERE id = :id", [":uid"=>$this->uid, ":id" => $this->getId()]);
        }
        return $this->uid;
    }
    public function setUid(string $uid): self
    {
        $this->uid = $uid;
        $this->setValue('uid', $uid);
        return $this;
    }

    /**
    * Gibt die JSON-LD-Darstellung des Events zurück.
    *
    * @return string Die JSON-LD-Darstellung des Events.
    *
    * Beispiel:
    * ```php
    * $jsonLd = $eventDate->getJsonLd();
    * ```
    *
    * ---
    *
    * Returns the JSON-LD representation of the event.
    *
    * @return string The JSON-LD representation of the event.
    *
    * Example:
    * ```php
    * $jsonLd = $eventDate->getJsonLd();
    * ```
    */
    public function getJsonLd(): string
    {
        $fragment = new rex_fragment();
        $fragment->setVar("event_date", $this);
        return $fragment->parse('event-date-single.json-ld.php');
    }
    public function setJsonLd(string $jsonLd): self
    {
        $this->setValue('json_ld', $jsonLd);
        return $this;
    }
    /**
    * Erstellt einen IntlDateFormatter für das angegebene Format und die angegebene Sprache.
    *
    * @param int $format_date Das Datumsformat. Standardwert ist IntlDateFormatter::FULL.
    * @param int $format_time Das Zeitformat. Standardwert ist IntlDateFormatter::SHORT.
    * @param string $lang Die Sprache. Standardwert ist "de".
    * @return IntlDateFormatter Der erstellte IntlDateFormatter.
    *
    * Beispiel:
    * ```php
    * $formatter = event_date::formatDate(IntlDateFormatter::FULL, IntlDateFormatter::SHORT, "de");
    * ```
    *
    * ---
    *
    * Creates an IntlDateFormatter for the specified format and language.
    *
    * @param int $format_date The date format. Default is IntlDateFormatter::FULL.
    * @param int $format_time The time format. Default is IntlDateFormatter::SHORT.
    * @param string $lang The language. Default is "de".
    * @return IntlDateFormatter The created IntlDateFormatter.
    *
    * Example:
    * ```php
    * $formatter = event_date::formatDate(IntlDateFormatter::FULL, IntlDateFormatter::SHORT, "de");
    * ```
    */
    public static function formatDate(int $format_date = IntlDateFormatter::FULL, int $format_time = IntlDateFormatter::SHORT, string $lang = "de"): IntlDateFormatter
    {
        return datefmt_create($lang, $format_date, $format_time, null, IntlDateFormatter::GREGORIAN);
    }

    /**
    * Erstellt ein DateTime-Objekt aus dem angegebenen Datum und der angegebenen Zeit.
    *
    * @param string $date Das Datum im Format "Y-m-d".
    * @param string $time Die Zeit im Format "H:i". Standardwert ist "00:00".
    * @return DateTime Das erstellte DateTime-Objekt.
    *
    * Beispiel:
    * ```php
    * $dateTime = $eventDate->getDateTime("2022-12-31", "23:59");
    * ```
    *
    * ---
    *
    * Creates a DateTime object from the specified date and time.
    *
    * @param string $date The date in "Y-m-d" format.
    * @param string $time The time in "H:i" format. Default is "00:00".
    * @return DateTime The created DateTime object.
    *
    * Example:
    * ```php
    * $dateTime = $eventDate->getDateTime("2022-12-31", "23:59");
    * ```
    */
    private function getDateTime(string $date, string $time = "00:00"): DateTime
    {
        $time = explode(":", $time);
        $dateTime = new DateTime($date);
        $dateTime->setTime($time[0], $time[1]);
        return $dateTime;
    }

    /**
    * Gibt das formatierte Startdatum des Events zurück.
    *
    * @param int $format_date Das Datumsformat. Standardwert ist IntlDateFormatter::FULL.
    * @param int $format_time Das Zeitformat. Standardwert ist IntlDateFormatter::NONE.
    * @return string Das formatierte Startdatum des Events.
    *
    * Beispiel:
    * ```php
    * $formattedStartDate = $eventDate->getFormattedStartDate();
    * ```
    *
    * ---
    *
    * Returns the formatted start date of the event.
    *
    * @param int $format_date The date format. Default is IntlDateFormatter::FULL.
    * @param int $format_time The time format. Default is IntlDateFormatter::NONE.
    * @return string The formatted start date of the event.
    *
    * Example:
    * ```php
    * $formattedStartDate = $eventDate->getFormattedStartDate();
    * ```
    */
    public function getFormattedStartDate(int $format_date = IntlDateFormatter::FULL, int $format_time = IntlDateFormatter::NONE): string
    {
        return self::formatDate($format_date, $format_time)->format($this->getDateTime($this->getValue("startDate"), $this->getStartTime()));
    }

    /**
    * Gibt das formatierte Enddatum des Events zurück.
    *
    * @param int $format_date Das Datumsformat. Standardwert ist IntlDateFormatter::FULL.
    * @param int $format_time Das Zeitformat. Standardwert ist IntlDateFormatter::SHORT.
    * @return string Das formatierte Enddatum des Events.
    *
    * Beispiel:
    * ```php
    * $formattedEndDate = $eventDate->getFormattedEndDate();
    * ```
    *
    * ---
    *
    * Returns the formatted end date of the event.
    *
    * @param int $format_date The date format. Default is IntlDateFormatter::FULL.
    * @param int $format_time The time format. Default is IntlDateFormatter::SHORT.
    * @return string The formatted end date of the event.
    *
    * Example:
    * ```php
    * $formattedEndDate = $eventDate->getFormattedEndDate();
    * ```
    */
    public function getFormattedEndDate(int $format_date = IntlDateFormatter::FULL, int $format_time = IntlDateFormatter::SHORT): string
    {
        return self::formatDate($format_date, $format_time)->format($this->getDateTime($this->getValue("endDate"), $this->getEndTime()));
    }

    /**
    * Gibt die formatierte Startzeit des Events zurück.
    *
    * @return string Die formatierte Startzeit des Events.
    *
    * Beispiel:
    * ```php
    * $formattedStartTime = $eventDate->getFormattedStartTime();
    * ```
    *
    * ---
    *
    * Returns the formatted start time of the event.
    *
    * @return string The formatted start time of the event.
    *
    * Example:
    * ```php
    * $formattedStartTime = $eventDate->getFormattedStartTime();
    * ```
    */
    public function getFormattedStartTime(): string
    {
        return $this->getStartTime();
    }
    /**
    * Gibt die formatierte Endzeit des Events zurück.
    *
    * @return string Die formatierte Endzeit des Events.
    *
    * Beispiel:
    * ```php
    * $formattedEndTime = $eventDate->getFormattedEndTime();
    * ```
    *
    * ---
    *
    * Returns the formatted end time of the event.
    *
    * @return string The formatted end time of the event.
    *
    * Example:
    * ```php
    * $formattedEndTime = $eventDate->getFormattedEndTime();
    * ```
    */
    public function getFormattedEndTime(): string
    {
        return $this->getEndTime();
    }

    /**
    * Gibt die Startzeit des Events zurück.
    *
    * @return string|null Die Startzeit des Events oder null, wenn keine Startzeit gesetzt ist.
    *
    * Beispiel:
    * ```php
    * $startTime = $eventDate->getStartTime();
    * ```
    *
    * ---
    *
    * Returns the start time of the event.
    *
    * @return string|null The start time of the event, or null if no start time is set.
    *
    * Example:
    * ```php
    * $startTime = $eventDate->getStartTime();
    * ```
    */
    public function getStartTime() : ?string
    {
        return $this->getValue('startTime');
    }
    public function setStartTime(string $startTime): self
    {
        $this->setValue('startTime', $startTime);
        return $this;
    }

    /**
    * Gibt die Endzeit des Events zurück.
    *
    * @return string|null Die Endzeit des Events oder null, wenn keine Endzeit gesetzt ist.
    *
    * Beispiel:
    * ```php
    * $endTime = $eventDate->getEndTime();
    * ```
    *
    * ---
    *
    * Returns the end time of the event.
    *
    * @return string|null The end time of the event, or null if no end time is set.
    *
    * Example:
    * ```php
    * $endTime = $eventDate->getEndTime();
    * ```
    */
    public function getEndTime() : ?string
    {
        return $this->getValue('endTime');
    }
    public function setEndTime(string $endTime): self
    {
        $this->setValue('endTime', $endTime);
        return $this;
    }
    /**
    * Gibt den Namen des Events zurück.
    *
    * @return string|null Der Name des Events oder null.
    *
    * Beispiel:
    * ```php
    * $name = $eventDate->getName();
    * ```
    *
    * ---
    *
    * Returns the name of the event.
    *
    * @return string|null The name of the event or null.
    *
    * Example:
    * ```php
    * $name = $eventDate->getName();
    * ```
    */
    public function getName() : ?string
    {
        return $this->getValue("name");
    }
    public function setName(string $name): self
    {
        $this->setValue('name', $name);
        return $this;
    }

    /**
    * Gibt die Beschreibung des Events zurück.
    *
    * @return string|null Die Beschreibung des Events oder null.
    *
    * Beispiel:
    * ```php
    * $description = $eventDate->getDescription();
    * ```
    *
    * ---
    *
    * Returns the description of the event.
    *
    * @return string|null The description of the event or null.
    *
    * Example:
    * ```php
    * $description = $eventDate->getDescription();
    * ```
    */
    public function getDescription() : ?string
    {
        return $this->getValue("description");
    }
    public function setDescription(string $description): self
    {
        $this->setValue('description', $description);
        return $this;
    }
    /**
    * Gibt die Beschreibung des Events als reinen Text zurück.
    *
    * @return string|null Die Beschreibung des Events als reiner Text oder null, wenn keine Beschreibung gesetzt ist.
    *
    * Beispiel:
    * ```php
    * $descriptionAsPlaintext = $eventDate->getDescriptionAsPlaintext();
    * ```
    */
    public function getDescriptionAsPlaintext() : ?string
    {
        return strip_tags($this->getValue("description"));
    }
    public function setDescriptionAsPlaintext(string $descriptionAsPlaintext): self
    {
        $this->setValue('description', $descriptionAsPlaintext);
        return $this;
    }

    /**
    * Gibt den Teaser des Events zurück.
    *
    * @return string|null Der Teaser des Events oder null.
    *
    * Beispiel:
    * ```php
    * $teaser = $eventDate->getTeaser();
    * ```
    *
    * ---
    *
    * Returns the teaser of the event.
    *
    * @return string|null The teaser of the event or null.
    *
    * Example:
    * ```php
    * $teaser = $eventDate->getTeaser();
    * ```
    */
    public function getTeaser() : ?string
    {
        return $this->getValue("teaser");
    }
    public function setTeaser(string $teaser): self
    {
        $this->setValue('teaser', $teaser);
        return $this;
    }

    /**
    * Gibt den Preis des Events zurück.
    *
    * Wenn das Event spezielle Angebote hat, wird der Preis des ersten Angebots zurückgegeben.
    * Wenn es keine Angebote gibt, wird der Preis der ersten Kategorie des Events zurückgegeben.
    *
    * @return string Der Preis des Events.
    *
    * Beispiel:
    * ```php
    * $price = $eventDate->getPrice();
    * ```
    *
    * ---
    *
    * Returns the price of the event.
    *
    * If the event has special offers, the price of the first offer is returned.
    * If there are no offers, the price of the first category of the event is returned.
    *
    * @return string The price of the event.
    *
    * Example:
    * ```php
    * $price = $eventDate->getPrice();
    * ```
    */
    public function getPrice(): string
    {
        /** @var rex_yform_manager_collection $offers */
        $offers = rex_yform_manager_table::get('rex_event_date_offer')->query()->where("date_id", $this->getValue('id'))->find();

        if (count($offers)) {
            /** @var event_date_offer $offer */
            $offer = $offers->first();
            return $offer->getPrice();
        }
        $category = $this->getCategories()->first();
        /** @var Category $category */
        return $category->getPrice();
    }

    /**
    * Gibt den formatierten Preis des Events zurück.
    *
    * Der Preis wird zusammen mit der Währung zurückgegeben, die in den Einstellungen festgelegt wurde.
    *
    * @return string Der formatierte Preis des Events.
    *
    * Beispiel:
    * ```php
    * $formattedPrice = $eventDate->getPriceFormatted();
    * ```
    *
    * ---
    *
    * Returns the formatted price of the event.
    *
    * The price is returned along with the currency set in the settings.
    *
    * @return string The formatted price of the event.
    *
    * Example:
    * ```php
    * $formattedPrice = $eventDate->getPriceFormatted();
    * ```
    */
    public function getPriceFormatted(): string
    {
        return $this->getPrice() . " " . rex_config::get('events', 'currency');
    }


    /* Informationen zur Registrierung und Anmeldung */

    /**
    * Gibt die Anzahl der verfügbaren Plätze für das Event zurück.
    *
    * @return int Die Anzahl der verfügbaren Plätze.
    *
    * Beispiel:
    * ```php
    * $spaceCount = $eventDate->getSpaceCount();
    * ```
    *
    * ---
    *
    * Returns the number of available spaces for the event.
    *
    * @return int The number of available spaces.
    *
    * Example:
    * ```php
    * $spaceCount = $eventDate->getSpaceCount();
    * ```
    */
    public function getSpaceCount() :int
    {
        return (int) $this->getTotalCount() - $this->countRegistrationPerson();
    }
    public function setSpaceCount(int $spaceCount): self
    {
        $this->setValue('space', $spaceCount);
        return $this;
    }

    /**
    * Gibt die Gesamtanzahl der Plätze für das Event zurück.
    *
    * @return int Die Gesamtanzahl der Plätze.
    *
    * Beispiel:
    * ```php
    * $totalCount = $eventDate->getTotalCount();
    * ```
    *
    * ---
    *
    * Returns the total number of spaces for the event.
    *
    * @return int The total number of spaces.
    *
    * Example:
    * ```php
    * $totalCount = $eventDate->getTotalCount();
    * ```
    */
    public function getTotalCount() :int
    {
        return (int) $this->getValue('space');
    }
    public function setTotalCount(int $totalCount): self
    {
        $this->setValue('space', $totalCount);
        return $this;
    }
    /**
    * Gibt die Anzahl der registrierten Personen für das Event zurück.
    *
    * @return int Die Anzahl der registrierten Personen.
    *
    * Beispiel:
    * ```php
    * $registerCount = $eventDate->getRegisterCount();
    * ```
    *
    * ---
    *
    * Returns the number of registered persons for the event.
    *
    * @return int The number of registered persons.
    *
    * Example:
    * ```php
    * $registerCount = $eventDate->getRegisterCount();
    * ```
    */
    public function getRegisterCount() :int
    {
        $registrations = Registration::getTotalRegistrationsByDate($this->getId());
        $count = 0;
        if ($registrations) {
            $count += array_sum(Registration::getTotalRegistrationsByDate($this->getId())->getValues('person_count'));
        }
        return (int) $count;
    }
    public function setRegisterCount(int $registerCount): self
    {
        $this->setValue('registerCount', $registerCount);
        return $this;
    }

    /**
    * Gibt den Prozentsatz der registrierten Personen im Verhältnis zur Gesamtanzahl der Plätze zurück.
    *
    * @return int Der Prozentsatz der registrierten Personen.
    *
    * Beispiel:
    * ```php
    * $registerPercentage = $eventDate->getRegisterCountPercentage();
    * ```
    *
    * ---
    *
    * Returns the percentage of registered persons in relation to the total number of spaces.
    *
    * @return int The percentage of registered persons.
    *
    * Example:
    * ```php
    * $registerPercentage = $eventDate->getRegisterCountPercentage();
    * ```
    */
    public function getRegisterCountPercentage() :int
    {
        if ($this->getTotalCount() > 0) {
            return (int) (100 / $this->getTotalCount() * $this->countRegistrationPerson());
        }
        return 0;
    }

    /**
    * Überprüft, ob das Event voll ist.
    *
    * @return bool True, wenn das Event voll ist, sonst false.
    *
    * Beispiel:
    * ```php
    * $isFull = $eventDate->isFull();
    * ```
    *
    * ---
    *
    * Checks whether the event is full.
    *
    * @return bool True if the event is full, otherwise false.
    *
    * Example:
    * ```php
    * $isFull = $eventDate->isFull();
    * ```
    */
    public function isFull() :bool
    {
        if ($this->getSpaceCount() <= 0) {
            return true;
        }
        return false;
    }

    /* Register-URL-Addon */

    public static function combineCidDid($cid, $did): string
    {
        return $cid . str_pad($did, 3, '0', STR_PAD_LEFT);
    }

    public function getRegisterUrl($category_id = null) :string
    {
        if ($category_id) {
            return rex_getUrl('', '', ['register-id' => self::combineCidDid($category_id, $this->getId())]);
        }
        return rex_getUrl('', '', ['event-date-id' => $this->getId()]);
    }

    public function getRegisterButton($category_id = null) :string
    {
        if ($this->isFull()) {
            return '<a class="btn disabled d-block">ausgebucht</a>';
        }
        return '<a class="btn btn-primary d-block"
href="'.$this->getRegisterUrl($category_id).'">Jetzt anmelden</a>';
    }

    public function getRegisterBar() :string
    {
        if ($this->isFull()) {
            return '
<div class="progress-bar bg-danger" role="progressbar"
style="width: '. $this->getRegisterCountPercentage() .'%;"
aria-valuenow="'. $this->countRegistrationPerson() .'"
aria-valuemin="0"
aria-valuemax="'. $this->getTotalCount() .'">
'.$this->countRegistrationPerson()."/".$this->getTotalCount().'
</div>';
        }
        return '
<div class="progress-bar bg-success" role="progressbar"
style="width: '. $this->getRegisterCountPercentage() .'%;"
aria-valuenow="'. $this->countRegistrationPerson() .'"
aria-valuemin="0"
aria-valuemax="'. $this->getTotalCount() .'">
'.$this->countRegistrationPerson()."/".$this->getTotalCount().'
</div>';
    }
    public function getIcon(): string
    {
        if ($category = $this->getCategory()) {
            /* @var event_category $category */
            return $category->getIcon();
        }
    }

    public function getRegistrationPerson($status = 0, $operator = ">="): ?rex_yform_manager_collection
    {
        return RegistrationPerson::query()->where('status', $status, $operator)->where('event_date_id', self::getId())->find();
    }
    public function countRegistrationPerson($status = 0, $operator = ">="): int
    {
        return count($this->getRegistrationPerson($status, $operator));
    }

            
    /* Sprach ID */
    /** @api */
    public function getLang() : ?rex_yform_manager_dataset {
        return $this->getRelatedDataset("lang_id");
    }

    /* Kategorie(n) */
    /** @api */
    public function getEventCategory() : ?rex_yform_manager_collection {
        return $this->getRelatedCollection("event_category_id");
    }

    /* Beginn Datum */
    /** @api */
    public function getStartDate() : ?string {
        return $this->getValue("startDate");
    }
    /** @api */
    public function setStartDate(mixed $value) : self {
        $this->setValue("startDate", $value);
        return $this;
    }

    /* ganztägig? */
    /** @api */
    public function getAllDay(bool $asBool = false) : mixed {
        if($asBool) {
            return (bool) $this->getValue("all_day");
        }
        return $this->getValue("all_day");
    }
    /** @api */
    public function setAllDay(int $value = 1) : self {
        $this->setValue("all_day", $value);
        return $this;
    }
            
    /* Einlass-Uhrzeit */
    /** @api */
    public function getDoorTime() : string {
        return $this->getValue("doorTime");
    }
    /** @api */
    public function setDoorTime(string $value = "00:00") : self {
        $this->setValue("doorTime", $value);
        return $this;
    }
            
    /* End-Datum */
    /** @api */
    public function getEndDate() : ?string {
        return $this->getValue("endDate");
    }
    /** @api */
    public function setEndDate(mixed $value) : self {
        $this->setValue("endDate", $value);
        return $this;
    }

    /* Freie Plätze */
    /** @api */
    public function getSpace() : ?float {
        return $this->getValue("space");
    }
    /** @api */
    public function setSpace(float $value) : self {
        $this->setValue("space", $value);
        return $this;
    }
            
    /* Titelbild */
    /** @api */
    public function getImagePoster(bool $asMedia = false) : mixed {
        if($asMedia) {
            return rex_media::get($this->getValue("image_poster"));
        }
        return $this->getValue("image_poster");
    }
    /** @api */
    public function setImagePoster(string $filename) : self {
        if(rex_media::get($filename)) {
            $this->setValue("image_poster", $filename);
        }
        return $this;
    }
            
    /* Galerie */
    /** @api */
    public function getImages(bool $asMedia = false) : mixed {
        if($asMedia) {
            return rex_media::get($this->getValue("images"));
        }
        return $this->getValue("images");
    }
    /** @api */
    public function setImages(string $filename) : self {
        if(rex_media::get($filename)) {
            $this->setValue("images", $filename);
        }
        return $this;
    }
            
    /* Externe URL */
    /** @api */
    public function getUrl() : ?string {
        return $this->getValue("url");
    }
    /** @api */
    public function setUrl(mixed $value) : self {
        $this->setValue("url", $value);
        return $this;
    }

    /* Video-URL */
    /** @api */
    public function getVideoUrl() : ?string {
        return $this->getValue("video_url");
    }
    /** @api */
    public function setVideoUrl(mixed $value) : self {
        $this->setValue("video_url", $value);
        return $this;
    }

    /* Status */
    /** @api */
    public function getEventStatus() : mixed {
        return $this->getValue("eventStatus");
    }
    /** @api */
    public function setEventStatus(mixed $param) : mixed {
        $this->setValue("eventStatus", $param);
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

    /* Zuletzt geändert von... */
    /** @api */
    public function getUpdateuser() : ?rex_user {
        return rex_user::get($this->getValue("updateuser"));
    }
    /** @api */
    public function setUpdateuser(mixed $value) : self {
        $this->setValue("updateuser", $value);
        return $this;
    }

    /* Zuletzt geändert am... */
    /** @api */
    public function getUpdatedate() : ?string {
        return $this->getValue("updatedate");
    }
    /** @api */
    public function setUpdatedate(string $value) : self {
        $this->setValue("updatedate", $value);
        return $this;
    }

    /* Angebote / Preise */
    /** @api */
    public function getOffer() : ?rex_yform_manager_dataset {
        return $this->getRelatedDataset("offer");
    }

    /* Startdatum und -zeit */
    /** @api */
    public function getStartDateTime() : ?string {
        return $this->getValue("startDateTime");
    }
    /** @api */
    public function setStartDateTime(mixed $value) : self {
        $this->setValue("startDateTime", $value);
        return $this;
    }

    public static function getStatusOptions() : array {
        return [
            '' => rex_i18n::msg('event_date_status_draft'),
            self::STATUS_EVENT_CANCELLED => rex_i18n::msg('event_date_status_cancelled'),
            self::STATUS_EVENT_POSTPONED => rex_i18n::msg('event_date_status_postponed'),
            self::STATUS_EVENT_RESCHEDULED => rex_i18n::msg('event_date_status_rescheduled'),
            self::STATUS_EVENT_SCHEDULED => rex_i18n::msg('event_date_status_scheduled'),
        ];
    }

}
