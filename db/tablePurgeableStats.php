<?php

namespace ClickerVolt;

require_once __DIR__ . '/tablePurgeable.php';

abstract class TablePurgeableStats extends TablePurgeable
{
    const CATEGORY_STATS_RAW = 'stats-raw';
    const CATEGORY_STATS_SUMMARY = 'stats-summary';

    abstract function getPurgeableCategory();
}
