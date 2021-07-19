<?php
$date = $this->event_date;
$offers = $date->getOfferAll();
$location = $date->getLocation();
?>
<script type="application/ld+json">
  {
    "@context": "https://schema.org",
    "@type": "Event",
    "name": "<?= $date->getValue('name')  ?>",
    "startDate": "<?= $date->getStartDate()->format(DateTimeInterface::ATOM) ?> ",
    "endDate": "<?= $date->getEndDate()->format(DateTimeInterface::ATOM)  ?>",
    "eventAttendanceMode": "https://schema.org/OfflineEventAttendanceMode",
    "eventStatus": "https://schema.org/EventScheduled",
    <?php if ($location) { ?>
    "location": {
      "@type": "Place",
      "name": "<?= $location->getValue('name') ?>",
      "address": {
        "@type": "PostalAddress",
        "streetAddress": "<?= $location->getValue('street') ?>",
        "addressLocality": "<?= $location->getValue('locality') ?>",
        "postalCode": "<?= $location->getValue('zip') ?>",
        "addressCountry": "<?= $location->getValue('countrycode') ?>"
      }
    },
    <?php } ?>
    "image": [
      "/media/<?= $date->getImage() ?>"
    ],
    "description": "<?= $date->getDescriptionAsPlainText() ?>",
    <?php if ($offers) { ?>
    "offers":
    <?php foreach ($offers as $offer) { ?>
    {
      "@type": "Offer",
      "url": "<?= $offer->getValue('url')  ?>",
      "price": "<?= $offer->getValue('price')  ?>",
      "priceCurrency": "<?= rex_config::get("events", "currency") ?>",
      "availability": "<?= $offer->getValue('availability') ?>",
      "validFrom": "<?= $date->getValue('createdate')  ?>"
    },
    <?php } ?>
    <?php } ?>
    "performer": {
      "@type": "PerformingGroup",
      "name": "<?= $date->getValue('name')  ?>"
    },
    "organizer": {
      "@type": "Organization",
      "name": "<?= rex_config::get("events/default_organizer_name") ?>",
      "url": "<?= rex_yrewrite::getCurrentDomain()->getName() ?>"
    }
  }
</script>