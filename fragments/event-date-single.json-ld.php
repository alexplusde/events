<?php
/**
 * @var rex_fragment $this
 * @var event_date $date
 */
$date = $this->getVar('event_date');
$offers = $date->getOfferAll();
$location = $date->getLocation();
$schemaUrl = "https://schema.org";
$currency = rex_config::get("events", "currency");

$jsonOptions = JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_NUMERIC_CHECK;
?>
<script type="application/ld+json">
	{
		"@context": "<?= $schemaUrl ?>",
		"@type": "Event",
		"name": <?= json_encode($date->getValue('name'), $jsonOptions) ?> ,
		"startDate": <?= json_encode($date->getValue('start_date')->format(DateTimeInterface::ATOM), $jsonOptions) ?> ,
		"endDate": <?= json_encode($date->getValue('end_date')->format(DateTimeInterface::ATOM), $jsonOptions) ?> ,
		"eventAttendanceMode": "<?= $schemaUrl ?>/OfflineEventAttendanceMode",
		"eventStatus": "<?= $schemaUrl ?>/EventScheduled",
		<?php if ($location) { ?>
		"location": {
			"@type": "Place",
			"name": <?= json_encode($location->getValue('name'), $jsonOptions) ?> ,
			"address": {
				"@type": "PostalAddress",
				"streetAddress": <?= json_encode($location->getValue('street'), $jsonOptions) ?> ,
				"addressLocality": <?= json_encode($location->getValue('locality'), $jsonOptions) ?> ,
				"postalCode": <?= json_encode($location->getValue('zip'), $jsonOptions) ?> ,
				"addressCountry": <?= json_encode($location->getValue('countrycode'), $jsonOptions) ?>
			}
		},
		<?php } ?>
		"image": "/media/<?= $date->getImage() ?>",
		"description": <?= json_encode($date->getDescriptionAsPlainText(), $jsonOptions) ?> ,
		<?php if ($offers) { ?>
		"offers":
		<?php foreach ($offers as $offer) { ?>
		{
			"@type": "Offer",
			"url": <?= json_encode($offer->getValue('url'), $jsonOptions) ?> ,
			"price": <?= json_encode($offer->getValue('price'), $jsonOptions) ?> ,
			"priceCurrency": <?= json_encode($currency, $jsonOptions) ?> ,
			"availability": <?= json_encode($offer->getValue('availability'), $jsonOptions) ?> ,
			"validFrom": <?= json_encode($date->getValue('createdate'), $jsonOptions) ?>
		},
		<?php } ?>
		<?php } ?>
		"performer": {
			"@type": "PerformingGroup",
			"name": <?= json_encode($date->getValue('name'), $jsonOptions) ?>
		},
		"organizer": {
			"@type": "Organization",
			"name": <?= json_encode(rex_config::get("events", "default_organizer_name"), $jsonOptions) ?> ,
			"url": <?= json_encode(rex_yrewrite::getCurrentDomain()->getName(), $jsonOptions) ?>
		}
	}
</script>
