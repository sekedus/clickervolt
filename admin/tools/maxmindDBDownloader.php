<?php

namespace ClickerVolt;

require_once __DIR__ . '/../../utils/fileTools.php';
require_once __DIR__ . '/../../utils/logger.php';
require_once __DIR__ . '/downloader.php';

class MaxmindDBDownloader
{
    /**
     * @throws \Exception
     */
    static function updateDBs()
    {
        if (extension_loaded('zip')) {
            $urls = [
                'dbs.zip' => 'http://clickervolt.com/files/maxminddbs/dbs.zip'
            ];
        } else {
            $urls = [
                "asn.mmdb" => "http://clickervolt.com/files/maxminddbs/asn.mmdb",
                "city.mmdb" => "http://clickervolt.com/files/maxminddbs/city.mmdb",
                "asn-list.txt" => "http://clickervolt.com/files/maxminddbs/asn-list.txt",
                "city-list.txt" => "http://clickervolt.com/files/maxminddbs/city-list.txt",
                "region-list.txt" => "http://clickervolt.com/files/maxminddbs/region-list.txt"
            ];
        }

        $responses = [];

        try {
            $timeout = 60 * 15;
            if (!set_time_limit($timeout)) {
                Logger::getErrorLogger()->log("Maxmind DB downloader could not change time limit");
            }

            $targetDir = FileTools::getDataFolderPath("maxmind_dbs");
            foreach ($urls as $k => $url) {
                $path = "{$targetDir}/{$k}";
                Downloader::singleton()->download($url, $path, $timeout);
                $responses[$k] = $path;
            }

            if (extension_loaded('zip')) {
                foreach ($responses as $filename => $path) {
                    if (strpos($filename, '.zip') !== false) {
                        $zip = new \ZipArchive;
                        $res = $zip->open("{$targetDir}/{$filename}");
                        if ($res === TRUE) {
                            $zip->extractTo($targetDir);
                            $zip->close();
                        }
                    }
                }
            }
        } catch (\Exception $ex) {
            foreach ($responses as $k => $path) {
                if (file_exists($path)) {
                    unlink($path);
                }
            }
            Logger::getErrorLogger()->log("Can't download maxmind files: {$ex}");
            throw $ex;
        }
    }
}
