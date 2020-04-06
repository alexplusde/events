BEGIN:VCALENDAR 
VERSION:2.0 
CALSCALE:GREGORIAN 
BEGIN:VEVENT
CREATED:<?= date('Ymd\THis', strtotime($this->event_date->getValue('createdate'))) ?> 
SUMMARY:<?= $this->event_date->getValue('name') ?>
DTSTART:<?= date('Ymd\THis', strtotime($this->event_date->getValue('startDate'))) ?> 
DTEND:<?= date('Ymd\THis', strtotime($this->event_date->getValue('endDate'))) ?> 
LAST-MODIFIED:<?= date('Ymd\THis', strtotime($this->event_date->getValue('updatedate'))) ?> 
LOCATION:<?= $this->event_date->getIcsLocation() ?> 
DESCRIPTION: <?= $this->event_date->getIcsDescription() ?> 
SEQUENCE:0 
STATUS:<?= $this->event_date->getIcsStatus() ?> 
UID:<?= $this->event_date->getIcsUid() ?> 
END:VEVENT 
END:VCALENDAR 