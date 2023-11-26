<?php
/**
 * Die `rex_yform_action_event_date_registration_person_fill` Klasse erweitert YForm um eine Aktion,
 * die es erleichtert, Teilnehmerlisten und Anmeldungen mit mehreren Personen zu erfassen,
 * wenn eine Registrierung mehr als eine Person beinhaltet.
 *
 * Sie erbt von der `rex_yform_action_abstract` Klasse und bietet zusätzliche Methoden
 * zur Interaktion mit den Anmeldungen eines Event-Datums.
 *
 * Beispiel:
 *
 * ```php
 * $yform->setActionField('event_date_registration_person_fill', []);
 * ```
 *
 * ---
 *
 * The `rex_yform_action_event_date_registration_person_fill` class extends YForm with an action,
 * that makes it easier to capture participant lists and registrations with multiple people,
 * when a registration includes more than one person.
 *
 * It inherits from the `rex_yform_action_abstract` class and provides additional methods
 * for interacting with the registrations of an event date.
 *
 * Example:
 * ```php
 * $yform->setActionField('event_date_registration_person_fill', []);
 * ```
 */
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
