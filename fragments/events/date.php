<?php

/** @var rex_fragment $this */
$date = $this->getVar('date');
$category = $date->getCategory();
?>
<div class=" event card mb-4">
	<div class="card-body">

		<p>
			<?php
                    $categories = $date->getCategories();
foreach($categories as $category) {
    ?>
			<span
				class="badge bg-primary"><?= $category->getName() ?></span>
			<?php
}
?>
			<?= $date->getFormattedStartDate() ?>,
			<?= $date->getFormattedStartTime() ?> Uhr
		</p>
		<h2 class="h4"><?= $date->getName() ?></h2>
		<p class=" events-teaser">
			<?= $date->getTeaser() ?>
		</p>
		<a href="<?= $date->getRegisterUrl() ?>"
			class="btn btn-medium btn-primary">{{ events.date.more}}</a>
	</div>

</div>
