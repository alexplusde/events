<?php

namespace Alexplusde\Events;

/** @var rex_fragment $this */

use rex_config;
?>
<a class="btn btn-secondary" href="<?= rex_getUrl(rex_config::get('events', 'article_id')) ?>">
    <i class="bi bi-arrow-left"></i> {{ events.list.back}}
</a>
