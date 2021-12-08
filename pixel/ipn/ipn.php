<?php

namespace ClickerVolt;

require_once __DIR__ . '/../actionHandler.php';
require_once __DIR__ . '/../../utils/arrayVars.php';

class IPNConversionProcessor
{
    const REQUEST_KEY_SUB_OBJECT_PATH_SEPARATOR = '..';

    private $actionParamsKeysToRequestKeys = [];

    /**
     * 
     */
    function __construct($convNameRequestKey, $convAmountRequestKey, $convClickIDRequestKey)
    {
        $this->actionParamsKeysToRequestKeys = [
            'actionName' => $convNameRequestKey,
            'actionRevenue' => $convAmountRequestKey,
            'clickId' => $convClickIDRequestKey
        ];
    }

    /**
     * 
     */
    static function newFromQueryVars()
    {
        $convNameRequestKey = ArrayVars::queryGet(ActionHandler::URL_PARAM_ACTION_NAME);
        $convAmountRequestKey = ArrayVars::queryGet(ActionHandler::URL_PARAM_ACTION_REVENUE);
        $convClickIDRequestKey = ArrayVars::queryGet(ActionHandler::URL_PARAM_CLICK_ID);

        return new self($convNameRequestKey, $convAmountRequestKey, $convClickIDRequestKey);
    }

    /**
     * 
     */
    function process($requestParams)
    {
        $action = $this->actionFromRequest($requestParams);
        $action->queue();
    }

    function actionFromRequest($requestParams)
    {
        $clickIDKey = $this->actionParamsKeysToRequestKeys['clickId'];
        if (ArrayVars::getFromPath($requestParams, $clickIDKey, null, self::REQUEST_KEY_SUB_OBJECT_PATH_SEPARATOR) === null) {
            throw new \Exception("IPN failed: no clickId available in array");
        }

        $actionParams = [
            'actionType' => ArrayVars::queryGet(ActionHandler::URL_PARAM_ACTION_TYPE, 'conversion'),
            'actionTimestamp' => time(),
        ];
        foreach ($this->actionParamsKeysToRequestKeys as $actionKey => $requestKey) {
            $requestVal = ArrayVars::getFromPath($requestParams, $requestKey, null, self::REQUEST_KEY_SUB_OBJECT_PATH_SEPARATOR);
            if ($requestVal !== null) {
                $actionParams[$actionKey] = $requestVal;
            }
        }

        return new Action($actionParams);
    }
}
