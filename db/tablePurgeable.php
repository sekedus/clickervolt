<?php

namespace ClickerVolt;

require_once __DIR__ . '/table.php';

abstract class TablePurgeable extends Table
{
    function purge($restricToColumnName = null, $restrictToColumnValue = null)
    {
        global $wpdb;
        $tableName = $this->wpTableName($this->getName());
        if ($restricToColumnName !== null && $restrictToColumnValue !== null) {
            $wpdb->query("delete from {$tableName} where {$restricToColumnName} = '{$restrictToColumnValue}'");
        } else {
            $wpdb->query("truncate table {$tableName}");
        }
    }
}
