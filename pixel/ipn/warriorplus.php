<?php

namespace ClickerVolt;

require_once __DIR__ . '/ipn.php';
require_once __DIR__ . '/../../utils/logger.php';

class IPNWarriorPlus
{
    static function getAffiliateSaleProcessor()
    {
        return new IPNConversionProcessor('WP_SALE', 'WP_SALE_EARNINGS_AFF', 'WP_HOP_SID');
    }

    static function getVendorSaleProcessor()
    {
        return new IPNConversionProcessor('WP_SALE', 'WP_SALE_EARNINGS_VENDOR', 'WP_HOP_SID');
    }
}

if (!empty($_POST) && !empty($_POST['WP_ACTION'])) {
    Logger::getGeneralLogger()->log("WarriorPlus IPN: " . json_encode($_POST));

    if (!empty($_POST['WP_SECURITYKEY'])) {
    }

    switch ($_POST['WP_ACTION']) {
        case 'sale':
            if (isset($_POST['IPN_RCPT_TYPE']) && $_POST['IPN_RCPT_TYPE'] == 'aff') {
                IPNWarriorPlus::getAffiliateSaleProcessor()->process($_POST);
            } else {
                IPNWarriorPlus::getVendorSaleProcessor()->process($_POST);
            }
            echo 'ok';
            break;

        case 'subscr_created':
        case 'subscr_completed':
            throw new \Exception("WarriorPlus subscription action not handled by IPN yet");
            break;

        case 'refund':
            throw new \Exception("WarriorPlus refunds not handled by IPN yet");
            break;
    }
}
