<?php
class event_date extends \rex_yform_manager_dataset 
{ 

    public function getCategory() { 
        return $this->getRelatedDataset('event_category_id'); 
    } 

}