<?php

namespace ClickerVolt;

class Session
{
    const URL_SESSION_KEY = 'session';
    const COOKIE_NAME = 'clickervolt-sid';

    /**
     * 
     */
    function get($key)
    {
        return empty($_SESSION[$key]) ? null : $_SESSION[$key];
    }

    /**
     * 
     */
    function set($key, $value)
    {
        $_SESSION[$key] = $value;
    }

    /**
     * 
     */
    function __construct($testMode = false)
    {
        if (!self::$sessionId && session_status() == PHP_SESSION_NONE) {
            self::$sessionId = null;

            require_once __DIR__ . '/../../db/objects/parallelId.php';
            $pidParam = ParallelId::fromURLOrParams(null, $_GET);
            if ($pidParam) {
                $pidVal = $pidParam->getValue();
                if (!self::isValidMd5($pidVal)) {
                    $pidVal = md5($pidVal);
                }
                self::$sessionId = $pidVal;
            }

            if (!self::$sessionId) {
                if (isset($_GET[self::URL_SESSION_KEY]) && self::isValidMd5($_GET[self::URL_SESSION_KEY])) {
                    self::$sessionId = $_GET[self::URL_SESSION_KEY];
                } else if (!empty($_SERVER['HTTP_REFERER'])) {
                    require_once __DIR__ . '/../../utils/urlTools.php';
                    $refParams = URLTools::getParams($_SERVER['HTTP_REFERER']);
                    if (isset($refParams[self::URL_SESSION_KEY]) && self::isValidMd5($refParams[self::URL_SESSION_KEY])) {
                        self::$sessionId = $refParams[self::URL_SESSION_KEY];
                    }
                }

                if (!self::$sessionId) {
                    self::$sessionId = filter_input(INPUT_COOKIE, self::COOKIE_NAME);
                }
            }

            if (!self::$sessionId || !self::isValidMd5(self::$sessionId)) {
                require_once __DIR__ . '/../../utils/ipTools.php';
                $footprints = [];
                $footprints[] = IPTools::getUserIP();
                // $footprints[] = empty($_SERVER['HTTP_USER_AGENT']) ? '' : $_SERVER['HTTP_USER_AGENT'];
                // $footprints[] = empty($_SERVER['HTTP_ACCEPT_LANGUAGE']) ? '' : $_SERVER['HTTP_ACCEPT_LANGUAGE'];
                self::$sessionId = md5(implode('|', $footprints));
            }

            if (!$testMode) {
                session_id(self::$sessionId);

                $sessionLifetime = 7 * 24 * 60 * 60;
                session_set_cookie_params($sessionLifetime, '/');
                session_start();

                $cookieLifetime = 365 * 24 * 60 * 60;
                setcookie(self::COOKIE_NAME, session_id(), time() + $cookieLifetime, '/');
                setcookie(session_name(), session_id(), time() + $sessionLifetime, '/');
            }
        }
    }

    static function getSessionId()
    {
        return self::$sessionId;
    }

    static function reset()
    {
        self::$sessionId = null;
    }

    static private function isValidMd5($md5 = '')
    {
        return strlen($md5) == 32 && ctype_xdigit($md5);
    }

    static private $sessionId = null;
}
