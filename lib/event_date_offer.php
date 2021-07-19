<?php
class event_date_offer extends \rex_yform_manager_dataset
{
    public function getUrl() :string
    {
        return $this->getValue('url');
    }
    public function getStatus() :string
    {
        return $this->getValue('status');
    }
    public function getPrice() :string
    {
        return $this->getValue('price');
    }
    public function getCurrency() :string
    {
        return $this->getValue('currency');
    }
    public function getAvialability() :string
    {
        return "https://schema.org/" . $this->status;
    }
}
