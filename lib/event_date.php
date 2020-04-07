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
        $this->category = $this->getRelatedDataset('event_category_id');
        return $this->category;
    }

    public function getIcs()
    {
        $fragment = new rex_fragment();
        $fragment->setVar("event_date", $this);
        return $fragment->parse('event-date-single.ics.php');
    }

    public function getLocation()
    {
        $this->location = $this->getRelatedDataset('location');
        return $this->location;
    }

    public function getOfferAll()
    {
        return $this->getRelatedCollection('offer'); // Fehlerhaft. Yform Issue #  
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
        if($this->uid === "") {
            $this->uid = self::generateUuid($this->id);
        }
        return $this->uid;
    }

    public function getJsonLd()
    {
        $fragment = new rex_fragment();
        $fragment->setVar("event_date", $this);
        return $fragment->parse('event-date-single.json-ld.php');
    }

    private function getDateTime($date = null, $time = "00:00") {

        $dateTime = new DateTime($date);
        $dateTime->sub($dateTime->format("H:i"));
        $dateTime->add($time);

        return $dateTime; 
    }

}
