<?php

echo rex_view::title($this->getProperty('page')['title']);

$addon = rex_addon::get('events');

$form = rex_config_form::factory($addon->getName());

$form->addFieldset(rex_i18n::msg('events_settings_fieldset_general'));

$field = $form->addInputField('text', 'default_organizer_name', null, ["class" => "form-control"]);
$field->setLabel(rex_i18n::msg('events_settings_default_organizer_name'));
$field->setNotice(rex_i18n::msg('events_settings_default_organizer_name_notice'));

$field = $form->addInputField('text', 'currency', null, ["class" => "form-control"]);
$field->setLabel(rex_i18n::msg('events_settings_currency'));
$field->setNotice(rex_i18n::msg('events_settings_currency_notice'));

$field = $form->addInputField('text', 'timezone_api_code', null, ["class" => "form-control"]);
$field->setLabel(rex_i18n::msg('events_settings_timezone'));
$field->setNotice(rex_i18n::msg('events_settings_timezone_notice'). '<a href="https://developers.google.com/maps/documentation/timezone/intro?hl=de">https://developers.google.com/maps/documentation/timezone/intro?hl=de</a>');

$field = $form->addInputField('text', 'editor', null, ['class' => 'form-control']);
$field->setLabel(rex_i18n::msg('events_settings_editor'));
$field->setNotice('z.B. <code>form-control redactor-editor--default</code>');

$form->addFieldset(rex_i18n::msg('events_settings_fieldset_details'));

/* Für Detailseiten */
$field = $form->addLinkmapField('article_id');
$field->setLabel(rex_i18n::msg('events_settings_article_id'));
$field->setNotice(rex_i18n::msg('events_settings_article_id_notice'));

$field = $form->addTextAreaField('empty', null, ['class' => 'form-control '. rex_config::get('events', 'editor')]);
$field->setLabel(rex_i18n::msg('events_settings_empty'));
$field->setNotice(rex_i18n::msg('events_settings_empty_notice'));

/* REX_MEDIA */
$field = $form->addMediaField('fallback_image');
$field->setLabel(rex_i18n::msg('events_settings_fallback_image'));
$field->setNotice(rex_i18n::msg('events_settings_fallback_image_notice'));

$form->addFieldset(rex_i18n::msg('events_settings_fieldset_registration'));

/* Für Anmeldungen */

$field = $form->addTextAreaField('withdrawal', null, ['class' => 'form-control '. rex_config::get('events', 'editor')]);
$field->setLabel($this->i18n('events_settings_withdrawal'));

$field = $form->addLinkmapField('privacy_policy');
$field->setLabel(rex_i18n::msg('events_settings_privacy_policy_id'));

$field = $form->addLinkmapField('agb');
$field->setLabel(rex_i18n::msg('events_settings_agb_id'));

$fragment = new rex_fragment();
$fragment->setVar('class', 'edit', false);
$fragment->setVar('title', $addon->i18n('events_settings'), false);
$fragment->setVar('body', $form->get(), false);
?>
<div class="row">
	<div class="col-lg-12">
		<?= $fragment->parse('core/page/section.php') ?>
	</div>
</div>
