<?php
namespace Alexplusde\Events;

/** @var rex_fragment $this */

$categories = Category::query()->where('status', 1, "=")->orderBy('name')->find();
$current_id = $this->getVar('category_id');

?>
<div class="card">
	<div class="card-header">
		Rubriken
	</div>
	<div class="list-group list-group-flush">
		<a class="list-group-item"
			href="<?= rex_getUrl(\rex_config::get('events', 'article_id')) ?>">{{ events.category.all}}</a>
		<?php

foreach ($categories as $category) {
	/** @var event_category $category */
	$isActive = $category->getId() == $current_id ? 'active' : ''; // Überprüfen, ob die aktuelle Kategorie die gleiche ist wie die Kategorie in der Schleife
	?>
	<a class="list-group-item <?= $isActive ?>"
		href="<?= $category->getUrl() ?>"><?= $category->getName() ?></a>

	<?php
}
?>	</div>
</div>
