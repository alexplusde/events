<?php
namespace Alexplusde\Events;

/** @var rex_fragment $this */

$category_id = $this->getVar('category_id');
if($category_id > 0) {
	$dates = Category::get($category_id)->getRelatedCollection('date_ids');
}
else {
	$dates = Date::query()->find();
}

$headline = $this->getVar('headline', '{{events.list.headline}}');

?>
<div class="banner_title">
	<div class="container">
		<div class="row">
			<div class="col-xl-8">
				<h1><?= $headline ?></h1>
			</div>
		</div>
	</div>
</div>
<section class="module- events-list">
	<div class="container">
		<div class=" events-list row g-4">
			<div class="col-12 col-md-3">
				<?php $this->subfragment("bs5/events/list-category.php"); ?>
			</div>
			<div class="col-12 col-md-9">
				<?php
foreach($dates as $date) {

    $this->setVar('date', $date);
    echo $this->subfragment("bs5/events/date.php");
}
?>
			</div>
		</div>
	</div>
</section>
