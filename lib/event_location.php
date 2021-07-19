<?php
class event_location extends \rex_yform_manager_dataset
{
    public function getAsString() :string
    {
        return $this->getValue('street') .", ". $this->getValue('zip') .", ".$this->getValue('locality').", ".$this->getValue('countrycode');
    }
    public function getName() :string
    {
        return $this->getValue('name');
    }
    
    public function getStreet() :string
    {
        return $this->getValue('street');
    }
    
    public function getZip() :string
    {
        return $this->getValue('zip');
    }
    
    public function getLocality() :string
    {
        return $this->getValue('locality');
    }
    public function getCountrycode() :string
    {
        return $this->getValue('countrycode');
    }
    public function getLatLng() :string
    {
        return $this->getValue('lat_lng');
    }
    public function getLat() :string
    {
        return $this->getValue('lat');
    }
    public function getLng() :string
    {
        return $this->getValue('lng');
    }
}
