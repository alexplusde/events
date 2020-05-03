<?php

use Ramsey\uuid\uuid;

class event_date extends \rex_yform_manager_dataset
{
    private $startDate = null;
    private $endDate = null;
    private $location = null;
    private $category = null;
    private $offer = null;

    public static function generateuuid($id = null) :string
    {
        return uuid::uuid3(uuid::NAMESPACE_URL, $id);
    }

    public function getCategory()
    {
        $this->category = $this->getRelatedDataset('event_category_id');
        return $this->category;
    }

    public function getIcs()
    {
        $UID = $this->getUid();
        $vCalendar = new \Eluceo\iCal\Component\Calendar('-//' . date("Y") . '//#' . rex::getServerName() . '//' . strtoupper((rex_clang::getCurrent())->getCode()));
        
        date_default_timezone_set(rex::getProperty('timezone'));
        
        $vEvent = new \Eluceo\iCal\Component\Event($UID);
        
        // date/time
        $vEvent
        ->setDtStart($this->getStartDate())
        ->setDtEnd($this->getEndDate())
        ->setCreated(new \DateTime($this->getCreateDate()))
        ->setCreated(new \DateTime($this->getCreateDate()))
        // ->setCategories(explode(",", $sked['entry']->category_name))
        ->setSummary($this->getEventName())
        ->setDescription($this->getDescriptionAsPlaintext())
        // ->setNoTime($is_fulltime) // Wenn Ganztag
        ->setUseTimezone(true);
        
        // location
        $locationICS = $this->getLocation();
        if (isset($locationICS)){
            $vEvent->setLocation($locationICS->getLocationAsString(), $locationICS->getValue('name'), $locationICS->getValue('lat') != '' ? $locationICS->getValue('lat') . ',' . $locationICS->getValue('lng') : '');
        }
        
        
        // 
        $vCalendar->addComponent($vEvent);
        
        header('Content-Type: text/calendar; charset=utf-8');
        header('Content-Disposition: attachment; filename="' . $this->getEventName() . '.ics"'); // Todo: Dateinamen generieren

        return $vCalendar->render();
        // ob_clean();
        
        // exit($vEvent);
    }

    public function getLocation()
    {
        $this->location = $this->getRelatedDataset('location');
        return $this->location;
    }

    public function getOfferAll()
    {
        // return $this->getRelatedCollection('offer'); // Fehlerhaft. Yform Issue #
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
        return strip_tags($this->description);
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

    private function getDateTime($date = null, $time = "00:00")
    {
        $time = explode(":", $time);
        $dateTime = new DateTime($date);
        $dateTime->setTime($time[0], $time[1]);

        return $dateTime;
    }

    public function getStartDate()
    {
        $this->startDate = $this->getDateTime($this->getValue("startDate"), $this->getValue("startTime"));
        return $this->startDate;
    }
    public function getEndDate()
    {
        $this->endDate = $this->getDateTime($this->getValue("endDate"), $this->getValue("endTime"));
        return $this->endDate;
    }
    public function getCreateDate()
    {
        $this->createDate = $this->getValue("createdate");
        return $this->createDate;
    }
    public function getEventName()
    {
        $this->eventName = $this->getValue("name");
        return $this->eventName;
    }
}
