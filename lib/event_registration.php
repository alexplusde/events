<?php

class event_registration extends \rex_yform_manager_dataset
{
    public static function getTotalRegistrationsByDate(int $date_id): ?rex_yform_manager_collection
    {
        return self::query()->where('date_id', $date_id)->where('status', '0', '>=')->find();
    }

    public function getRegistrationPerson(int $status = 0, string $operator = ">="): ?rex_yform_manager_collection
    {
        return event_registration_person::query()->where('status', $status, $operator)->where('event_date_id', self::getDateId())->find();
    }

    public function countRegistrationPerson(int $status = 0, string $operator = ">="): int {
        return count($this->getRegistrationPerson($status, $operator));
    }

    public function getPersonTotal(): int
    {
        return $this->getValue('person_count');
    }

    public static function ep_saved($ep): bool
    {
        $lastId = $ep->getSubject()->getLastId();
        $table  = $ep->getParam('table');

        return true;
    }
    
    public function getCategoryId(): int
    {
        return $this->getValue('category_id');
    }
    public function getCategory(): ?rex_yform_manager_collection
    {
        return $this->getRelatedDataset('category_id');
    }

    public function getDateId(): int
    {
        return $this->getValue('date_id');
    }

    public function getDate(): ?rex_yform_manager_collection
    {
        return $this->getRelatedDataset('date_id');
    }

    public function getLocationId(): int
    {
        return $this->getValue('event_location_id');
    }

    public function getSalutation(): string
    {
        return $this->getValue('salutation');
    }

    public function getFirstName(): string
    {
        return $this->getValue('firstname');
    }

    public function getLastName(): string
    {
        return $this->getValue('lastname');
    }

    public function getName(bool $reverse = false): string
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

    public function getEmail(): string
    {
        return $this->getValue('email');
    }

    public function getStreet(): string
    {
        return $this->getValue('street');
    }

    public function getPostalCode(): string
    {
        return $this->getValue('zip');
    }

    public function getZip(): string
    {
        return $this->getValue('zip');
    }

    public function getCity(): string
    {
        return $this->getValue('city');
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
    
    public function getPayment(): string
    {
        return $this->getValue('payment');
    }

    public function getMessage(): string
    {
        return $this->getValue('message');
    }

    public function getChannel(): string
    {
        return $this->getValue('channel');
    }

    public function getStatus(): int
    {
        return $this->getValue('status');
    }

    public function getPrice(): float
    {
        return $this->getValue('price');
    }

    public function getUuid(): string
    {
        return $this->getValue('uuid');
    }

    public function hasAcceptedNewsletter(): bool
    {
        return $this->getValue('newsletter');
    }

    public function hasAcceptedAgb(): bool
    {
        return $this->getValue('agb');
    }

    public function hasAcceptedPrivacyPolicy(): bool
    {
        return $this->getValue('dsgvo');
    }

    public static function getByUuid(string $uuid = null): ?rex_yform_manager_collection
    {
        if (!$uuid) {
            return null;
        }
        return self::query()->where('uuid', $uuid)->findOne();
    }

    public function getHash(): string
    {
        return $this->getValue('hash');
    }

    public static function getByHash(string $hash = null): ?rex_yform_manager_collection
    {
        if (!$hash) {
            return null;
        }
        return self::query()->where('hash', $hash)->findOne();
    }
}
