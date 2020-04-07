<?php
class event_date extends \rex_yform_manager_dataset
{
    private $location = null;
    private $category = null;

    public function generateUid()
    {
        $uuid = uuid_make($context, UUID_MAKE_V3, rex::getServer(), $this->id);
        return trim($uuid);
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
        return $this->uid;
    }

    public function getJsonLd()
    {
        $fragment = new rex_fragment();

        dump($this);
        $fragment->setVar("event_date", $this);
        return $fragment->parse('event-date-single.json-ld.php');
    }
}
