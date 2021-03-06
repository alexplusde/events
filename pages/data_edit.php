<?php
$target_page = rex_request('page', 'string');
if ($target_page == 'yform/manager/data_edit') {
    $table_name = rex_request('table_name', 'string');
    $wrapper = '';
    $show_title = true;
} elseif (isset(rex_package::get("events")->getProperty('pages')[rex_be_controller::getCurrentPagePart(1)])) {
    # page-Properties allgemein abrufen
    $properties = rex_package::get("events")->getProperty('pages')[rex_be_controller::getCurrentPagePart(1)];
    if ($sub=rex_be_controller::getCurrentPagePart(2)) {
        $properties = $properties['subpages'][$sub];
    }
    # yform-properties
    $table_name = isset($properties['yformTable']) ? $properties['yformTable'] : '';
    $wrapper = isset($properties['yformClass']) ? $properties['yformClass'] : '';
    $show_title = $properties['yformTitle'] ?? false;
} else {
    $table_name = '';
}

$table = rex_yform_manager_table::get($table_name);

if ($table && rex::getUser() && (rex::getUser()->isAdmin() || rex::getUser()->getComplexPerm('yform_manager_table')->hasPerm($table->getTableName()))) {
    try {
        $page = new rex_yform_manager();
        $page->setTable($table);
        $page->setLinkVars(['page' => $target_page, 'table_name' => $table->getTableName()]);

        if ($wrapper) {
            echo "<div class=\"$wrapper\">";
        }

        if ($show_title) {
            echo $page->getDataPage();
        } else {
            # Seite erzeugen und abfangen
            ob_start();
            echo $page->getDataPage();
            $page = ob_get_clean();
            # Such den Header - Fall 1: mit Suchspalte?
            $p = strpos($page, '<div class="row">');
            # Such den Header - Fall 2: ohne Suchspalte
            if ($p === false) {
                $p = strpos($page, '<section class="rex-page-section">');
            }
            # Header rauswerfen
            if ($p !== false) {
                $page = ''.substr($page, $p);
            }
            # ausgabe
            echo $page;
        }

        if ($wrapper) {
            echo '</div>';
        }
    } catch (Exception $e) {
        $message = nl2br($e->getMessage()."\n".$e->getTraceAsString());
        echo rex_view::warning($message);
    }
} elseif (!$table) {
    echo rex_view::warning(rex_i18n::msg('yform_table_not_found'));
}
