<?php

use Ramsey\uuid\uuid;

class event_date extends \rex_yform_manager_dataset
{
    private $location = null;
    private $category = null;
    private $offer = null;

    public static function generateuuid($id = null) :string
    {
        return uuid::uuid3(uuid::NAMESPACE_URL, $id);
    }

    public function getCategory()
    {
        $this->category = event_category::get((int)$this->getValue('event_category_id'));
        return $this->category;
    }
    public function getCategories()
    {
        $this->categories = $this->getRelatedCollection('event_category_id');
        return $this->categories;
    }

    public function getIcs()
    {
        $UID = $this->getUid();
        
        $vCalendar = new \Eluceo\iCal\Component\Calendar('-//' . date("Y") . '//#' . rex::getServerName() . '//' . strtoupper((rex_clang::getCurrent())->getCode()));
        date_default_timezone_set(rex::getProperty('timezone'));
        
        $vEvent = new \Eluceo\iCal\Component\Event($UID);
        
        // date/time
        $vEvent
        ->setUseTimezone(true)
        ->setDtStart($this->getStartDate())
        ->setDtEnd($this->getEndDate())
        ->setCreated(new \DateTime($this->getValue("createdate")))
        ->setModified(new \DateTime($this->getValue("updatedate")))
        ->setNoTime($this->getValue("all_day"))
        // ->setNoTime($is_fulltime) // Wenn Ganztag
        // ->setCategories(explode(",", $sked['entry']->category_name))
        ->setSummary($this->getName())
        ->setDescription($this->getDescriptionAsPlaintext());
        
        // add location
        $locationICS = $this->getLocation();
        if (isset($locationICS)) {
            $ics_lat = $locationICS->getValue('lat');
            $ics_lng = $locationICS->getValue('lng');
            $vEvent->setLocation($locationICS->getAsString(), $locationICS->getValue('name'), $ics_lat != '' ? $ics_lat . ',' . $ics_lng : '');
            // fehlt: set timezone of location
        }
        
        //  add event to calendar
        $vCalendar->addComponent($vEvent);
        
        return $vCalendar->render();
        // ob_clean();
        
        // exit($vEvent);
    }

    public function getLocation()
    {
        if ($this->location === null) {
            $this->location = $this->getRelatedDataset('location');
        }
        return $this->location;
    }
    public function getLocationId()
    {
        return $this->getValue('location');
    }
    
    public function getTimezone($lat, $lng)
    {
        $event_timezone = "https://maps.googleapis.com/maps/api/timezone/json?location=" . $lat . "," . $lng . "&timestamp=" . time() . "&sensor=false";
        $event_location_time_json = file_get_contents($event_timezone);
        return $event_location_time_json;
    }

    public function getOfferAll()
    {
        return $this->getRelatedCollection('offer');
    }

    public function getImage() :string
    {
        return $this->image;
    }
    public function getMedia()
    {
        return rex_media::get($this->image);
    }

    public function getDescriptionAsPlaintext() :string
    {
        return strip_tags(html_entity_decode($this->description));
    }
    public function getIcsStatus()
    {
        return strip_tags($this->eventStatus);
    }
    public function getUid()
    {
        if ($this->uid === "" && $this->getValue("uid") === "") {
            $this->uid = self::generateUuid($this->id);

            rex_sql::factory()->setQuery("UPDATE rex_event_date SET uid = :uid WHERE id = :id", [":uid"=>$this->uid, ":id" => $this->getId()]);
        }
        return $this->uid;
    }

    public function getJsonLd()
    {
        $fragment = new rex_fragment();
        $fragment->setVar("event_date", $this);
        return $fragment->parse('event-date-single.json-ld.php');
    }

    public static function formatDate($format_date = IntlDateFormatter::FULL, $format_time = IntlDateFormatter::SHORT, $lang = "de")
    {
        return datefmt_create($lang, $format_date, $format_time, null, IntlDateFormatter::GREGORIAN);
    }

    private function getDateTime($date, $time = "00:00")
    {
        $time = explode(":", $time);
        $dateTime = new DateTime($date);
        $dateTime->setTime($time[0], $time[1]);

        return $dateTime;
    }

    public function getFormattedStartDate($format_date = IntlDateFormatter::FULL, $format_time = IntlDateFormatter::NONE)
    {
        return self::formatDate($format_date, $format_time)->format($this->getDateTime($this->getValue("startDate"), $this->getStartTime()));
    }


    public function getFormattedEndDate($format_date = IntlDateFormatter::FULL, $format_time = IntlDateFormatter::SHORT)
    {
        return self::formatDate($format_date, $format_time)->format($this->getDateTime($this->getValue("endDate"), $this->getEndTime()));
    }
    
    public function getFormattedStartTime()
    {
        return $this->getStartTime();
    }
    public function getFormattedEndTime()
    {
        return $this->getEndTime();
    }
    public function getStartTime()
    {
        return $this->getValue('startTime');
    }
    public function getEndTime()
    {
        return $this->getValue('endTime');
    }

    public function getName()
    {
        return $this->getValue("name");
    }
    public function getPrice()
    {
        $offer = rex_yform_manager_table::get('rex_event_date_offer')->query()->where("date_id", $this->getValue('id'))->find();

        if (count($offer) > 0) {
            return $offer[0]->getPrice();
        }
        return $this->getCategories()[0]->getPrice();
    }
    public function getPriceFormatted()
    {
        return $this->getPrice() . rex_config::get('events', 'currency');
    }
    

    /* Informationen zur Registrierung und Anmeldung */

    public function getSpaceCount() :int
    {
        return (int) $this->getTotalCount() - $this->getRegisterCount();
    }
    public function getTotalCount() :int
    {
        return (int) $this->getValue('space');
    }
    public function getRegisterCount() :int
    {
        $registrations = event_registration::getTotalRegistrationsByDate($this->getId());
        $count = 0;
        if ($registrations) {
            $count += array_sum(event_registration::getTotalRegistrationsByDate($this->getId())->getValues('person_count'));
        }
        return (int) $count;
    }
    public function getRegisterCountPercentage() :int
    {
        if ($this->getTotalCount() > 0) {
            return (int) (100 / $this->getTotalCount() * $this->getRegisterCount());
        }
        return 0;
    }
    public function isFull() :bool
    {
        if ($this->getSpaceCount() <= 0) {
            return true;
        }
        return false;
    }
    /* Register-URL-Addon */
    
    public static function combineCidDid($cid, $did)
    {
        return $cid . str_pad($did, 3, '0', STR_PAD_LEFT);
    }

    public function getRegisterUrl($category_id = null) :string
    {
        if ($category_id) {
            return rex_getUrl('', '', ['event-date-id' => self::combineCidDid($category_id, $this->getId())]);
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
            aria-valuenow="'. $this->getRegisterCount() .'"
            aria-valuemin="0"
            aria-valuemax="'. $this->getTotalCount() .'">
            '.$this->getRegisterCount()."/".$this->getTotalCount().'
            </div>';
        }
        return '
        <div class="progress-bar bg-success" role="progressbar"
        style="width: '. $this->getRegisterCountPercentage() .'%;"
        aria-valuenow="'. $this->getRegisterCount() .'"
        aria-valuemin="0"
        aria-valuemax="'. $this->getTotalCount() .'">
        '.$this->getRegisterCount()."/".$this->getTotalCount().'
        </div>';
    }
    public function getIcon()
    {
        if ($category = $this->getCategory()) {
            return $category->getIcon();
        }
    }
}
