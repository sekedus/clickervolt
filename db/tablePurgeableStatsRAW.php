<?php

namespace ClickerVolt;

require_once __DIR__ . '/tablePurgeableStats.php';

abstract class TablePurgeableStatsRAW extends TablePurgeableStats
{
    function getPurgeableCategory()
    {
        return self::CATEGORY_STATS_RAW;
    }
}
