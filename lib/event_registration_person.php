<?php

class event_registration_person extends \rex_yform_manager_dataset
{
    public function getName($reverse = false): string
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
    public function getFirstName(): string
    {
        return $this->getValue('firstname');
    }
    public function getLastName(): string
    {
        return $this->getValue('lastname');
    }
    public function getMail(): string
    {
        return $this->getValue('email');
    }
    public function getPhone(): string
    {
        return $this->getValue('phone');
    }
    public function getBirthday(): string
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
    
    public function getStatus(): int
    {
        return $this->getValue('status');
    }

    public function getEventDateId(): int
    {
        return $this->getValue('event_date_id');
    }
    public function getRegistrationId(): int
    {
        return $this->getValue('registration_id');
    }

    public function getRegistration(): object
    {
        return $this->getRelatedDataset('registration_id');
    }

    public function getCategoryId(): int
    {
        return $this->getRegistration()->getCategory()->getId();
    }

    public function getHash(): string
    {
        return $this->getValue('hash');
    }
    
    public static function getByUuid($uuid = null): object
    {
        if (!$uuid) {
            return;
        }
        return self::query()->where('uuid', $uuid)->findOne();
    }
    public static function getByHash($hash = null): object
    {
        if (!$hash) {
            return;
        }
        return self::query()->where('hash', $hash)->findOne();
    }
    public static function ep_saved($ep): bool
    {
        $lastId = $ep->getSubject()->getLastId();
        $table  = $ep->getParam('table');

        return true;
    }
}
