<?php
class event_location extends \rex_yform_manager_dataset
{
    public function getLocationAsString() :string
    {
        return $this->getValue('street') .", ". $this->getValue('zip') .", ".$this->getValue('locality').", ".$this->getValue('countrycode');
    }
}
