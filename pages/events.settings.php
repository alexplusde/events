<?php

echo rex_view::title($this->getProperty('page')['title']);

$addon = rex_addon::get('events');

$form = rex_config_form::factory($addon->getName());

$field = $form->addInputField('text', 'currency', null, ["class" => "form-control"]);
$field->setLabel(rex_i18n::msg('events_currency'));

$field = $form->addInputField('text', 'register_name', null, ["class" => "form-control"]);
$field->setLabel(rex_i18n::msg('register_name_label'));
$field->setLabel(rex_i18n::msg('register_name_description'));

$field = $form->addInputField('text', 'timezone_api_code', null, ["class" => "form-control"]);
$field->setLabel(rex_i18n::msg('events_timezone'));
$field->setNotice(rex_i18n::msg('events_timezone_notice'). '<a href="https://developers.google.com/maps/documentation/timezone/intro?hl=de">https://developers.google.com/maps/documentation/timezone/intro?hl=de</a>');

$field = $form->addInputField('text', 'default_organizer_name', null, ["class" => "form-control"]);
$field->setLabel(rex_i18n::msg('events_default_organizer_name'));
$field->setNotice(rex_i18n::msg('events_default_organizer_name_notice'));

$field = $form->addInputField('text', 'editor', null, ['class' => 'form-control']);
$field->setLabel(rex_i18n::msg('events_editor'));
$field->setNotice('z.B. <code>form-control redactor-editor--default</code>');

$field = $form->addTextAreaField('empty', null, ['class' => 'form-control '. rex_config::get('events', 'editor')]);
$field->setLabel(rex_i18n::msg('events_empty'));
$field->setNotice('Mitteilung, die ausgegeben werden soll, wenn keine Termine vorhanden sind.');

$field = $form->addTextAreaField('withdrawal', null, ['class' => 'form-control '. rex_config::get('events', 'editor')]);
$field->setLabel($this->i18n('events_withdrawal'));

$field = $form->addLinkmapField('privacy_policy');
$field->setLabel(rex_i18n::msg('events_privacy_policy_id'));

$field = $form->addLinkmapField('agb');
$field->setLabel(rex_i18n::msg('events_agb_id'));

$fragment = new rex_fragment();
$fragment->setVar('class', 'edit', false);
$fragment->setVar('title', $addon->i18n('events_settings'), false);
$fragment->setVar('body', $form->get(), false);
?>
<div class="row">
	<div class="col-lg-8">
		<?= $fragment->parse('core/page/section.php') ?>
	</div>
	<div class="col-lg-4">
		<?php

$anchor = '<a target="_blank" href="https://donate.alexplus.de/?addon=events"><img src="'.rex_url::addonAssets('events', 'jetzt-beauftragen.svg').'" style="width: 100% max-width: 400px;"></a>';

$fragment = new rex_fragment();
$fragment->setVar('class', 'info', false);
$fragment->setVar('title', $this->i18n('events_donate'), false);
$fragment->setVar('body', '<p>' . $this->i18n('events_info_donate') . '</p>' . $anchor, false);
echo !rex_config::get("alexplusde", "donated") ? $fragment->parse('core/page/section.php') : "";
?>
	</div>
</div>
