<?php

$addon = rex_addon::get('events');

$form = rex_config_form::factory($addon->name);

$field = $form->addInputField('text', 'currency', null, ["class" => "form-control"]);
$field->setLabel('Währung');


$fragment = new rex_fragment();
$fragment->setVar('class', 'edit', false);
$fragment->setVar('title', $addon->i18n('events_settings'), false);
$fragment->setVar('body', $form->get(), false);
echo $fragment->parse('core/page/section.php');

