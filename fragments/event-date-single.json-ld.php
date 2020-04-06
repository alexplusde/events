<script type="application/ld+json">
  {
    "@context": "https://schema.org",
    "@type": "Event",
    "name": "<?= $this->name ?>",
    "startDate": "<?= $this->startDate ?> ",
    "endDate": "<?= $this->endDate ?>",
    "eventAttendanceMode": "https://schema.org/OfflineEventAttendanceMode",
    "eventStatus": "https://schema.org/EventScheduled",
    "location": {
      "@type": "Place",
      "name": "<?= $this->getLocation()->name ?>",
      "address": {
        "@type": "PostalAddress",
        "streetAddress": "<?= $this->getLocation()->street ?>",
        "addressLocality": "<?= $this->getLocation()->locality ?>",
        "postalCode": "<?= $this->getLocation()->zip ?>"
        /*,
               "addressRegion": "PA",
               "addressCountry": "US" */
      }
    },
    "image": [
      "<?= $this->getImage() ?>"
    ],
    "description": <?= $this->getDescriptionAsPlainText() ?> ,
    "offers": {
      "@type": "Offer",
      "url": "<?= $this->offer_url ?>",
      "price": "<?= $this->offer_price ?>",
      "priceCurrency": "EUR",
      "availability": "https://schema.org/InStock",
      "validFrom": "<?= $this->updatedate ?>"
    },
    "performer": {
      "@type": "PerformingGroup",
      "name": "<?= $this->performer ?>"
    }
  }
</script>