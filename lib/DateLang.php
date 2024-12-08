<?php 

namespace Alexplusde\Events;

use rex_yform_manager_dataset;

class DateLang extends \rex_yform_manager_dataset {
	
    /* Name */
    /** @api */
    public function getName() : ?string {
        return $this->getValue("name");
    }
    /** @api */
    public function setName(mixed $value) : self {
        $this->setValue("name", $value);
        return $this;
    }

    /* Code */
    /** @api */
    public function getCode() : ?string {
        return $this->getValue("code");
    }
    /** @api */
    public function setCode(mixed $value) : self {
        $this->setValue("code", $value);
        return $this;
    }

    /* Termine */
    /** @api */
    public function getEventDate() : ?rex_yform_manager_dataset {
        return $this->getRelatedDataset("event_date");
    }

}?>
