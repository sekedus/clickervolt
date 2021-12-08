<?php

namespace ClickerVolt;

require_once __DIR__ . '/table.php';

class CustomReport implements ArraySerializer
{
    use ArraySerializerImpl;

    private $id;
    private $name;
    private $linkId;
    private $sourceId;
    private $segments;

    function __construct($id, $name, $linkId, $sourceId, $segments)
    {
        $this->id = $id;
        $this->name = $name;
        $this->linkId = $linkId;
        $this->sourceId = $sourceId;
        $this->segments = $segments ?: [];
    }

    function getId()
    {
        return $this->id;
    }

    function getName()
    {
        return $this->name;
    }

    function getLinkId()
    {
        return $this->linkId;
    }

    function getSourceId()
    {
        return $this->sourceId;
    }

    function getSegments()
    {
        return $this->segments;
    }
}

class TableCustomReports extends Table
{
    const SEGMENT_SEPARATOR = '[,,]';

    /**
     * 
     */
    public function getName()
    {
        return $this->wpTableName('clickervolt_custom_reports');
    }

    /**
     * 
     */
    public function setup($oldVersion, $newVersion)
    {
        global $wpdb;

        $tableName = $this->getName();

        if (!$this->doesTableExist()) {
            $sql = "CREATE TABLE {$tableName} (
                        `id` int unsigned not null auto_increment,
                        `name` varchar(128) not null,
                        `linkId` int unsigned null,
                        `sourceId` char(16) null,
                        `segments` varchar(255) not null,
                        primary key (`id`),
                        unique key `name_idx` (`name`),
                        key `linkId_idx` (`linkId`),
                        key `sourceId_idx` (`sourceId`)
                    ) ENGINE=InnoDB DEFAULT CHARSET=utf8";

            $res = $wpdb->query($sql);
            if ($res === false) {
                throw new \Exception("Cannot create table {$tableName}: {$wpdb->last_error}");
            }
        } else if ($oldVersion) {
        }
    }

    /**
     * 
     * @return \ClickerVolt\CustomReport[] - where keys are report IDs
     */
    public function loadAll()
    {
        global $wpdb;

        $reports = [];

        $tableName = $this->getName();
        $rows = $wpdb->get_results("select * from {$tableName}", ARRAY_A);

        if (!empty($rows)) {
            foreach ($rows as $row) {
                $report = $this->rowToReport($row);
                $reports[$report->getId()] = $report;
            }
        }

        return $reports;
    }

    /**
     * @return CustomReport
     */
    private function rowToReport($row)
    {
        $segments = explode(self::SEGMENT_SEPARATOR, $row['segments']);
        return new CustomReport($row['id'], $row['name'], $row['linkId'], $row['sourceId'], $segments);
    }

    /**
     * @param \ClickerVolt\CustomReport $report
     * @return id of the inserted report
     * @throws \Exception
     */
    public function insert($report)
    {
        global $wpdb;

        if ($report->getId()) {
            throw new \Exception("Custom report cannot be inserted into DB when id is already filled");
        }

        if (!$wpdb->insert($this->getName(), $this->getReportDataForDB($report))) {
            throw new \Exception("Custom report could not be saved into DB: " . $wpdb->last_error);
        }

        $report->fromArray(['id' => $wpdb->insert_id]);
        return $wpdb->insert_id;
    }

    /**
     * @param \ClickerVolt\CustomReport $report
     * @throws \Exception
     */
    public function update($report)
    {
        global $wpdb;

        if (!$report->getId()) {
            throw new \Exception("Custom report cannot be updated when id is not filled");
        }

        if (
            false === $wpdb->update(
                $this->getName(),
                $this->getReportDataForDB($report),
                [
                    'id' => $report->getId()
                ]
            )
        ) {
            throw new \Exception("Custom report could not be updated in DB: " . $wpdb->last_error);
        }
    }

    /**
     * @param int $id
     */
    public function delete($id)
    {
        global $wpdb;
        if (false === $wpdb->delete($this->getName(), ['id' => $id])) {
            throw new \Exception("Could not delete report with id '{$id}': " . $wpdb->last_error);
        }
    }

    private function getReportDataForDB($report)
    {
        return [
            'name' => $report->getName(),
            'linkId' => $report->getLinkId(),
            'sourceId' => $report->getSourceId(),
            'segments' => implode(self::SEGMENT_SEPARATOR, $report->getSegments()),
        ];
    }
}
