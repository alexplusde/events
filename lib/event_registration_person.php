<?php

class event_registration_person extends \rex_yform_manager_dataset
{
    public function getName($reverse = false)
    {
        $name = [];
        if ($reverse) {
            $name[] = $this->getLastName() . ",";
            $name[] = $this->getFirstName();
        }
        if (!$reverse) {
            $name[] = $this->getFirstName();
            $name[] = $this->getLastName();
        }
        return implode(" ", $name);
    }
    public function getFirstName()
    {
        return $this->getValue('firstname');
    }
    public function getLastName()
    {
        return $this->getValue('lastname');
    }
    public function getMail()
    {
        return $this->getValue('email');
    }
    public function getPhone()
    {
        return $this->getValue('phone');
    }
    public function getBirthday()
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
    
    public function getStatus()
    {
        return $this->getValue('status');
    }

    public function getEventDateId()
    {
        return $this->getValue('event_date_id');
    }
    public function getRegistrationId()
    {
        return $this->getValue('registration_id');
    }

    public function getCategoryId()
    {
        return $this->getValue('category_id');
    }

    public function getFormUrl()
    {
        return rex_article::get(rex_config::get('event', 'event_date_registration_person_article_id')->getUrl(["person" => $this->getValue('hash')], "&"));
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
    public static function ep_saved($ep)
    {
        $lastId = $ep->getSubject()->getLastId();
        $table  = $ep->getParam('table');

        return true;
    }
}
