<?php 

namespace Alexplusde\Events;

use rex_yform_manager_dataset;

class CategoryRequest extends \rex_yform_manager_dataset {
	
    /* Status */
    /** @api */
    public function getStatus() : mixed {
        return $this->getValue("status");
    }
    /** @api */
    public function setStatus(mixed $param) : mixed {
        $this->setValue("status", $param);
        return $this;
    }

    /* Kategorie */
    /** @api */
    public function getCategoryId() : ?rex_yform_manager_dataset {
        return $this->getRelatedDataset("category_id");
    }

    /* Termin */
    /** @api */
    public function getDate() : ?string {
        return $this->getValue("date");
    }
    /** @api */
    public function setDate(mixed $value) : self {
        $this->setValue("date", $value);
        return $this;
    }

    /* Kategorie-Name */
    /** @api */
    public function getCategory() : ?string {
        return $this->getValue("category");
    }
    /** @api */
    public function setCategory(mixed $value) : self {
        $this->setValue("category", $value);
        return $this;
    }

    /* Anrede */
    /** @api */
    public function getSalutation() : ?string {
        return $this->getValue("salutation");
    }
    /** @api */
    public function setSalutation(mixed $value) : self {
        $this->setValue("salutation", $value);
        return $this;
    }

    /* Vorname */
    /** @api */
    public function getFirstname() : mixed {
        return $this->getValue("firstname");
    }
    /** @api */
    public function setFirstname(mixed $value) : self {
        $this->setValue("firstname", $value);
        return $this;
    }

    /* Nachname */
    /** @api */
    public function getLastname() : mixed {
        return $this->getValue("lastname");
    }
    /** @api */
    public function setLastname(mixed $value) : self {
        $this->setValue("lastname", $value);
        return $this;
    }

    /* E-Mail */
    /** @api */
    public function getEmail() : ?string {
        return $this->getValue("email");
    }
    /** @api */
    public function setEmail(mixed $value) : self {
        $this->setValue("email", $value);
        return $this;
    }

    /* Straße */
    /** @api */
    public function getStreet() : ?string {
        return $this->getValue("street");
    }
    /** @api */
    public function setStreet(mixed $value) : self {
        $this->setValue("street", $value);
        return $this;
    }

    /* PLZ */
    /** @api */
    public function getZip() : mixed {
        return $this->getValue("zip");
    }
    /** @api */
    public function setZip(mixed $value) : self {
        $this->setValue("zip", $value);
        return $this;
    }

    /* Stadt */
    /** @api */
    public function getCity() : mixed {
        return $this->getValue("city");
    }
    /** @api */
    public function setCity(mixed $value) : self {
        $this->setValue("city", $value);
        return $this;
    }

    /* Telefon */
    /** @api */
    public function getPhone() : ?string {
        return $this->getValue("phone");
    }
    /** @api */
    public function setPhone(mixed $value) : self {
        $this->setValue("phone", $value);
        return $this;
    }

    /* Geburtstag */
    /** @api */
    public function getBirthday() : ?string {
        return $this->getValue("birthday");
    }
    /** @api */
    public function setBirthday(mixed $value) : self {
        $this->setValue("birthday", $value);
        return $this;
    }

    /* Teilnehmeranzahl */
    /** @api */
    public function getPersonCount() : ?float {
        return $this->getValue("person_count");
    }
    /** @api */
    public function setPersonCount(float $value) : self {
        $this->setValue("person_count", $value);
        return $this;
    }
            
    /* Nachricht */
    /** @api */
    public function getMessage(bool $asPlaintext = false) : ?string {
        if($asPlaintext) {
            return strip_tags($this->getValue("message"));
        }
        return $this->getValue("message");
    }
    /** @api */
    public function setMessage(mixed $value) : self {
        $this->setValue("message", $value);
        return $this;
    }
            
    /* Newsletter-Einwilligung */
    /** @api */
    public function getNewsletter(bool $asBool = false) : mixed {
        if($asBool) {
            return (bool) $this->getValue("newsletter");
        }
        return $this->getValue("newsletter");
    }
    /** @api */
    public function setNewsletter(int $value = 1) : self {
        $this->setValue("newsletter", $value);
        return $this;
    }
            
    /* DSGVO-Einwilligung */
    /** @api */
    public function getDsgvo(bool $asBool = false) : mixed {
        if($asBool) {
            return (bool) $this->getValue("dsgvo");
        }
        return $this->getValue("dsgvo");
    }
    /** @api */
    public function setDsgvo(int $value = 1) : self {
        $this->setValue("dsgvo", $value);
        return $this;
    }
            
    /* AGB-Einwilligung */
    /** @api */
    public function getAgb(bool $asBool = false) : mixed {
        if($asBool) {
            return (bool) $this->getValue("agb");
        }
        return $this->getValue("agb");
    }
    /** @api */
    public function setAgb(int $value = 1) : self {
        $this->setValue("agb", $value);
        return $this;
    }
            
    /* Empfehlung über... */
    /** @api */
    public function getChannel() : ?string {
        return $this->getValue("channel");
    }
    /** @api */
    public function setChannel(mixed $value) : self {
        $this->setValue("channel", $value);
        return $this;
    }

    /* Anmeldung erfolgt am... */
    /** @api */
    public function getCreatedate() : ?string {
        return $this->getValue("createdate");
    }
    /** @api */
    public function setCreatedate(string $value) : self {
        $this->setValue("createdate", $value);
        return $this;
    }

    /* Wird gelöscht am... */
    /** @api */
    public function getDeletedate() : ?\DateTime {
        return $this->getValue("deletedate");
    }
    /** @api */
    public function setDeletedate(mixed $value) : self {
        $this->setValue("deletedate", $value);
        return $this;
    }

    /* UUID */
    /** @api */
    public function getUuid() : mixed {
        return $this->getValue("uuid");
    }
    /** @api */
    public function setUuid(mixed $value) : self {
        $this->setValue("uuid", $value);
        return $this;
    }

}?>
