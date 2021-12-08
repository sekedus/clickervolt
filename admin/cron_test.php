<?php

namespace ClickerVolt;

require_once __DIR__ . '/../../../../wp-load.php';
require_once __DIR__ . '/../../../../wp-includes/load.php';
require_once __DIR__ . '/cron.php';

Cron::processClicksQueue(true);
