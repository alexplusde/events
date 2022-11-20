<?php

class event_registration extends \rex_yform_manager_dataset
{
    public static function getTotalRegistrationsByDate($date_id)
    {
        return self::query()->where('date_id', $date_id)->where('status', '0', '>')->find();
    }

    public function getPersonTotal()
    {
        return $this->getValue('person_count');
    }

    public static function ep_saved($ep)
    {
        $lastId = $ep->getSubject()->getLastId();
        $table  = $ep->getParam('table');

        return true;
    }
    
    public function getCategoryId()
    {
        return $this->getValue('category_id');
    }
    public function getDateId()
    {
        return $this->getValue('date_id');
    }
    public function getDate()
    {
        return $this->getRelatedDataset('date_id');
    }
    public function getLocationId()
    {
        return $this->getValue('event_location_id');
    }
    public function getSalutation()
    {
        return $this->getValue('salutation');
    }
    public function getFirstName()
    {
        return $this->getValue('firstname');
    }
    public function getLastName()
    {
        return $this->getValue('lastname');
    }
    public function getName($reverse = false)
    {
        $name = [];
        if ($this->getSalutation() !== "") {
            $name[] = $this->getSalutation();
        }
        if ($reverse) {
            $name[] = $this->getLastName() . ",";
            $name[] = $this->getFirstName();
            return implode(",", $name);
        }
        if (!$reverse) {
            $name[] = $this->getFirstName();
            $name[] = $this->getLastName();
            return implode(" ", $name);
        }
    }
    
    public function getEmail()
    {
        return $this->getValue('email');
    }
    public function getStreet()
    {
        return $this->getValue('street');
    }
    public function getPostalCode()
    {
        return $this->getValue('zip');
    }
    public function getZip()
    {
        return $this->getValue('zip');
    }
    public function getCity()
    {
        return $this->getValue('city');
    }
    public function getPhone()
    {
        return $this->getValue('phone');
    }
    public function getBirthday() :string
    {
        return $this->getValue('birthday');
    }
    
    public function getBirthdayFormatted($format = "Y-m-d H:i:s") :string
    {
        if ($this->getBirthday() == "0000-00-00") {
            return "";
        } else {
            $date = date_create($this->getBirthday());
            return date_format($date, $format);
        }
    }
    
    public function getPayment()
    {
        return $this->getValue('payment');
    }
    public function getMessage()
    {
        return $this->getValue('message');
    }
    public function getChannel()
    {
        return $this->getValue('channel');
    }
    public function getStatus()
    {
        return $this->getValue('status');
    }
    public function getPrice()
    {
        return $this->getValue('price');
    }
    public function getUuid()
    {
        return $this->getValue('uuid');
    }
    public function hasAcceptedNewsletter()
    {
        return $this->getValue('newsletter');
    }
    public function hasAcceptedAgb()
    {
        return $this->getValue('newsletter');
    }
    public function hasAcceptedPrivacyPolicy()
    {
        return $this->getValue('dsgvo');
    }
    public static function getByUuid($uuid = null)
    {
        if (!$uuid) {
            return;
        }
        return self::query()->where('uuid', $uuid)->findOne();
    }
    public static function getByHash($hash = null)
    {
        if (!$hash) {
            return;
        }
        return self::query()->where('hash', $hash)->findOne();
    }
}
