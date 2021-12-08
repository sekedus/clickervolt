<?php

namespace ClickerVolt;

require_once __DIR__ . '/ipn.php';
require_once __DIR__ . '/../../utils/logger.php';

class IPNPayKickstart
{
    static function getProcessor()
    {
        return IPNConversionProcessor::newFromQueryVars();
    }
}

if (!empty($_POST)) {
    Logger::getGeneralLogger()->log("PayKickStart IPN: " . json_encode($_POST));
    IPNPayKickstart::getProcessor()->process($_POST);
    echo 'ok';
} else {
    Logger::getGeneralLogger()->log("PayKickStart IPN without POST data...:" . json_encode($_REQUEST));
}
