<?php
class event_category extends \rex_yform_manager_dataset
{
    public function getName(): string
    {
        return $this->name;
    }
    public function getImage(): string
    {
        return $this->image;
    }
    public function getMedia(): rex_media
    {
        return rex_media::get($this->image);
    }
    
    public function getIcon(): string
    {
        return $this->getValue('icon');
    }
    public function getPrice(): string
    {
        return $this->getValue('msg_price');
    }
    public function getUrl(): string
    {
        return rex_getUrl('', '', ['event-category-id' => $this->getId()]);
    }

    public function getDateWhere($whereRaw = ''): ?rex_yform_manager_collection
    {
        return event_date::query()->joinRelation('event_category_id', 'c')->where('c.id', $this->getId())->whereRaw($whereRaw)->orderBy('startDate`, `startTime', 'DESC')->find();
    }
    
    public function getRelatedDates($whereRaw = ''): array
    {
        return $this->getDateWhere($whereRaw);
    }

    public function getAttributes(): array
    {
        return explode(",", $this->getValue('msg_form_presets'));
    }
    public function hasAttribute($needle): bool
    {
        return in_array($needle, $this->getAttributes());
    }
}
