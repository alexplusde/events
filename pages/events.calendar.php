<?php

$body = '<div id="fullcalendar"></div>';

$fragment = new rex_fragment();
$fragment->setVar('class', 'edit', false);
$fragment->setVar('title', "Kalender-Ansicht", false);
$fragment->setVar('body', $body, false);
echo $fragment->parse('core/page/section.php');
