<?php

namespace ClickerVolt;

require_once __DIR__ . '/ajax.php';
require_once __DIR__ . '/../../db/objects/cvSettings.php';

class AjaxCVSettings extends Ajax
{
    /**
     * throws \Exception
     */
    static function save()
    {
        $fraudDetectionMode = $_POST['fraudOptions']['mode'];
        $recaptchaSiteKey = $_POST['fraudOptions']['recaptcha3SiteKey'];
        $recaptchaSecretKey = $_POST['fraudOptions']['recaptcha3SecretKey'];
        $recaptchaHideBadge = (empty($_POST['fraudOptions']['recaptcha3HideBadge']) || $_POST['fraudOptions']['recaptcha3HideBadge'] == 'false')
            ? ''
            : 'yes';
        $ipDetectionType = $_POST['ipDetectionType'];

        CVSettings::set(CVSettings::RECAPTCHA3_SITE_KEY, $recaptchaSiteKey);
        CVSettings::set(CVSettings::RECAPTCHA3_SECRET_KEY, $recaptchaSecretKey);
        CVSettings::set(CVSettings::RECAPTCHA3_HIDE_BADGE, $recaptchaHideBadge);
        CVSettings::set(CVSettings::IP_DETECTION_TYPE, $ipDetectionType);
        CVSettings::set(CVSettings::FRAUD_DETECTION_MODE, $fraudDetectionMode);
        CVSettings::update();
    }
};
