<?php

namespace ClickerVolt;

class ErrorsCatcher
{
    static private $started = false;

    static function start()
    {
        if (!self::$started) {
            set_error_handler(function ($errno, $errstr, $errfile, $errline) {
                if (strpos($errfile, 'clickervolt') !== false) {
                    self::exception(new \ErrorException($errstr, $errno, 0, $errfile, $errline));
                }
            });
            set_exception_handler('\\ClickerVolt\\ErrorsCatcher::exception');

            self::$started = true;
        }
    }

    static function exception($e)
    {
        if (strpos($e->getFile(), 'clickervolt') !== false) {
            require_once __DIR__ . '/../utils/logger.php';
            Logger::getErrorLogger()->log($e);
        }
    }
}
