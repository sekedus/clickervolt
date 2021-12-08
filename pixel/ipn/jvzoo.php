<?php

namespace ClickerVolt;

require_once __DIR__ . '/ipn.php';
require_once __DIR__ . '/../../utils/logger.php';

class IPNJVZoo
{
    const RATE_KEY = 'rate';
    const AMOUNT_KEY = 'ctransamount';

    static function getAffiliateSaleProcessor()
    {
        return new IPNConversionProcessor('ctransreceipt', self::AMOUNT_KEY, 'caffitid');
    }
}

if (!empty($_POST) && !empty($_POST['ctransaction'])) {
    Logger::getGeneralLogger()->log("JVZoo IPN: " . json_encode($_POST));

    switch ($_POST['ctransaction']) {
        case 'SALE':
            if (!empty($_POST['caffitid'])) {
                if (!empty($_GET[IPNJVZoo::RATE_KEY]) && is_numeric($_GET[IPNJVZoo::RATE_KEY]) && !empty($_POST[IPNJVZoo::AMOUNT_KEY])) {
                    // Affiliate IPN from JVZoo does NOT take the commission rate into account.
                    // It sends the full price instead, so we need to calculate the rate manually...
                    $rate = $_GET[IPNJVZoo::RATE_KEY];
                    if ($rate > 0 && $rate <= 1.0) {
                        $_POST[IPNJVZoo::AMOUNT_KEY] *= $rate;
                    }
                }
                IPNJVZoo::getAffiliateSaleProcessor()->process($_POST);
            }
            echo 'ok';
            break;

        default:
            throw new \Exception("JVZoo transaction type '{$_POST['ctransaction']}' not handled by IPN yet");
            break;
    }
}
