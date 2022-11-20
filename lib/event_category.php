<?php
class event_category extends \rex_yform_manager_dataset
{
    public function getName() :string
    {
        return $this->name;
    }
    public function getImage() :string
    {
        return $this->image;
    }
    public function getMedia()
    {
        return rex_media::get($this->image);
    }
    
    public function getIcon()
    {
        return $this->getValue('icon');
    }
    public function getPrice()
    {
        return $this->getValue('msg_price');
    }
    public function getUrl()
    {
        return rex_getUrl('', '', ['category-id' => $this->getId()]);
    }

    public function getDateWhere($whereRaw = '')
    {
        return event_date::query()->joinRelation('event_category_id', 'c')->where('c.id', $this->getId())->whereRaw($whereRaw)->orderBy('startDate`, `startTime', 'DESC')->find();
    }
    
    public function getRelatedDates($whereRaw = '')
    {
        return $this->getDateWhere($whereRaw);
    }

    public function getAttributes()
    {
        return explode(",", $this->getValue('msg_form_presets'));
    }
    public function hasAttribute($needle)
    {
        return in_array($needle, $this->getAttributes());
    }
}
