BEGIN:VCALENDAR
VERSION:2.0
CALSCALE:GREGORIAN
BEGIN:VEVENT
CREATED:<?= date('Ymd\THis', $this->createdate) ?>
SUMMARY:Access-A-Ride Pickup
DTSTART:<?= date('Ymd\THis', $this->startDate) ?>
DTEND:<?= date('Ymd\THis', $this->endDate) ?>
LAST-MODIFIED:<?= date('Ymd\THis', $this->updatedate) ?>
LOCATION:<?= $this->getIcsLocation ?>
DESCRIPTION: <?= $this->getIcsDescription() ?>
SEQUENCE:0
STATUS:<?= $this->getIcsStatus() ?>
UID:<?= $this->getIcsUid() ?>
END:VEVENT
END:VCALENDAR