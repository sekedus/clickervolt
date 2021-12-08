<?php

namespace ClickerVolt;

require_once ABSPATH . 'wp-admin/includes/file.php';

// Sometimes an exec() call to curl works while the wordpress function download_url() doesn't...
// We try them both here to maximize our chances of a successful download 

class Downloader
{
    static function singleton()
    {
        if (!self::$singleton) {
            self::$singleton = new self();
        }
        return self::$singleton;
    }

    function download($url, $intoFile, $timeout = 300)
    {
        $tmpFile = "{$intoFile}.tmp";
        if (file_exists($tmpFile)) {
            unlink($tmpFile);
        }
        if (function_exists("exec")) {
            exec("curl --output {$tmpFile} -k -L '{$url}'");
        }
        if (!file_exists($tmpFile)) {
            $response = download_url($url, $timeout);
            if (is_wp_error($response)) {
                // sometimes an exec() call to curl directly works while the wordpress function
                // download_url doesn't...
                throw new \Exception("download_url() failed ({$response->get_error_message()}");
            }
            rename($response, $tmpFile);
        }

        if (!file_exists($tmpFile)) {
            throw new \Exception("all attempts to download '{$url}' into '{$intoFile}' failed");
        }

        if (file_exists($intoFile)) {
            unlink($intoFile);
        }
        rename($tmpFile, $intoFile);
    }

    private function __construct()
    {
    }

    static private $singleton = null;
}
