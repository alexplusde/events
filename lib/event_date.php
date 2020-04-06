<?php
class event_date extends \rex_yform_manager_dataset
{
    private $location = null;
    private $category = null;

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

    public function getIcsLocation()
    {
        $this->location = $this->getRelatedDataset('location');
        return $this->location->getValue('street') .", ". $this->location->getValue('zip') .", ".$this->location->getValue('locality').", ".$this->location->getValue('countryCode');
    }

    public function getImage()
    {
        return $this->image;
    }

    public function getIcsDescription()
    {
        return strip_tags($this->description);
    }
    public function getIcsStatus()
    {
        return strip_tags($this->eventStatus);
    }
    public function getIcsUid()
    {
        return strip_tags($this->id);
    }

    public function getDescriptionAsPlainText()
    {
        return strip_tags($this->description);
    }

    public function getJsonLd()
    {
        $fragment = new rex_fragment();

        dump($this);
        $fragment->setVar("event_date", $this);
        return $fragment->parse('event-date-single.json-ld.php');
    }
}
