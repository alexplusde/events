<?php 
?>
<script type="application/ld+json">
  {
    "@context": "https://schema.org",
    "@type": "Event",
    "name": "<?= $this->event_date->getValue('name')  ?>",
    "startDate": "<?= $this->event_date->getValue('startDate')  ?> ",
    "endDate": "<?= $this->event_date->getValue('endDate')  ?>",
    "eventAttendanceMode": "https://schema.org/OfflineEventAttendanceMode",
    "eventStatus": "https://schema.org/EventScheduled",
    "location": {
      "@type": "Place",
      "name": "<?= $this->event_date->getLocation()->getValue('name') ?>",
      "address": {
        "@type": "PostalAddress",
        "streetAddress": "<?= $this->event_date->getLocation()->getValue('street') ?>",
        "addressLocality": "<?= $this->event_date->getLocation()->getValue('locality') ?>",
        "postalCode": "<?= $this->event_date->getLocation()->getValue('zip')  ?>"
        /*,
               "addressRegion": "PA",
               "addressCountry": "US" */
      }
    },
    "image": [
      "<?= $this->event_date->getImage() ?>"
    ],
    "description": <?= $this->event_date->getDescriptionAsPlainText() ?> ,
    "offers": {
      "@type": "Offer",
      "url": "<?= $this->event_date->getValue('offers_url')  ?>",
      "price": "<?= $this->event_date->getValue('offers_price')  ?>",
      "priceCurrency": "EUR",
      "availability": "https://schema.org/InStock",
      "validFrom": "<?= $this->event_date->getValue('updatedate')  ?>"
    },
    "performer": {
      "@type": "PerformingGroup",
      "name": "<?= $this->event_date->getValue('performer')  ?>"
    }
  }
</script>