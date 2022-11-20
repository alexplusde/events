<?php

class rex_yform_action_event_date_registration_person_fill extends rex_yform_action_abstract
{
    public function executeAction(): void
    {
        $person_count = $this->params['value_pool']['sql']['person_count'];
        $firstname = $this->params['value_pool']['sql']['firstname'];
        $lastname = $this->params['value_pool']['sql']['lastname'];
        $email = $this->params['value_pool']['sql']['email'];
        $birthday = $this->params['value_pool']['sql']['birthday'];
        $phone = $this->params['value_pool']['sql']['phone'];

        $registration_id = $this->params['value_pool']['email']['id'];
        $date_id = $this->params['value_pool']['sql']['date_id'];

        for ($i = 1; $i <= $person_count; $i++) {
            $person = event_registration_person::create();
            if ($i == 1) {
                $person->setValue('firstname', $firstname);
                $person->setValue('lastname', $lastname);
                $person->setValue('email', $email);
                $person->setValue('birthday', $birthday);
                $person->setValue('phone', $phone);
            } else {
                $person->setValue('firstname', "Bitte Name angeben");
                $person->setValue('email', "");
            }
            $person->setValue('status', 0);
            $person->setValue('event_date_id', $date_id);
            $person->setValue('registration_id', $registration_id);

            if ($person->save()) {
            } else {
                $this->params['warning_messages'][] =implode('<br>', $person->getMessages());
            }
        }
    }

    public function getDescription(): string
    {
        return 'action|event_date_registration_person_fill';
    }
}
