<?php
class event_location extends \rex_yform_manager_dataset
{
    public function getLocationAsString() :string
    {
        return $this->getValue('street') .", ". $this->getValue('zip') .", ".$this->getValue('locality').", ".$this->getValue('countrycode');
    }
    public function getLocationName() :string
    {
        return $this->getValue('name');
    }
    
    public function getLocationStreet() :string
    {
        return $this->getValue('street');
    }
    
    public function getLocationZip() :string
    {
        return $this->getValue('zip');
    }
    
    public function getLocationLocality() :string
    {
        return $this->getValue('locality');
    }
    public function getLocationCountrycode() :string
    {
        return $this->getValue('countrycode');
    }
    public function getLocationLatLng() :string
    {
        return $this->getValue('lat_lng');
    }
    public function getLocationLat() :string
    {
        return $this->getValue('lat');
    }
    public function getLocationLng() :string
    {
        return $this->getValue('lng');
    }
    
}
