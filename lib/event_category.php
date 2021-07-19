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
}
