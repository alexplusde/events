<?php

namespace Alexplusde\Events;

use Url\Url;

$event = null;
$manager = Url::resolveCurrent();
if ($manager) {
    /** @var Date|Category $event */
    $event = $manager->getDataset();

}
?>
<!-- BEGIN plus_bs5/fragments/events/index.php -->
<?php
if($event instanceof Category) {
    echo $this->subFragment('bs5/events/list-category.php');
}

if($event instanceof Date) {
    echo $this->subFragment('bs5/events/date-details.php', ['event' => $event]);
}

if($event === null) {
    echo $this->subFragment('bs5/events/list.php');
}
?>
<!-- END plus_bs5/fragments/events/index.php -->
