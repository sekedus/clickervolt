<?php

namespace ClickerVolt;

require_once __DIR__ . '/tablePurgeableStats.php';

abstract class TablePurgeableStatsSummary extends TablePurgeableStats
{
    function getPurgeableCategory()
    {
        return self::CATEGORY_STATS_SUMMARY;
    }
}
