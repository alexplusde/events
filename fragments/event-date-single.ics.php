<?php
$date = $this->event_date;
$location = $date->getLocation();
?>
BEGIN:VCALENDAR 
VERSION:2.0 
CALSCALE:GREGORIAN 
BEGIN:VEVENT
CREATED:<?= date('Ymd\THis', strtotime($date->getValue('createdate'))) ?> 
SUMMARY:<?= $date->getValue('teaser') ?>
DTSTART:<?= date('Ymd\THis', strtotime($date->getValue('startDate'))) ?> 
DTEND:<?= date('Ymd\THis', strtotime($date->getValue('endDate'))) ?> 
LAST-MODIFIED:<?= date('Ymd\THis', strtotime($date->getValue('updatedate'))) ?> 
<?php if ($location) { ?>
LOCATION:<?= $location->getLocationAsString() ?>
<?php } ?> 
DESCRIPTION: <?= $date->getDescriptionAsPlaintext() ?> 
SEQUENCE:0 
STATUS:<?= $date->getIcsStatus() ?> 
UID:<?= $date->getUid() ?> 
END:VEVENT 
END:VCALENDAR 