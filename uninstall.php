<?php
rex_config::removeNamespace("events");

if (rex_addon::get('yform')->isAvailable() && !rex::isSafeMode()) {
  rex_yform_manager_table_api::removeTable('rex_event_date');
  rex_yform_manager_table_api::removeTable('rex_event_date_lang');
  rex_yform_manager_table_api::removeTable('rex_event_category');
  rex_yform_manager_table_api::removeTable('rex_event_location');
  rex_yform_manager_table_api::removeTable('rex_event_date_registration');
  rex_yform_manager_table_api::removeTable('rex_event_date_registration_person');
  rex_yform_manager_table_api::removeTable('rex_event_category_request');
}
