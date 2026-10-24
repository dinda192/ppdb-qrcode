<?php

// Set environment langsung di runtime
$_ENV['LOG_CHANNEL'] = 'stderr';
$_SERVER['LOG_CHANNEL'] = 'stderr';

$_ENV['VIEW_COMPILED_PATH'] = '/tmp';
$_SERVER['VIEW_COMPILED_PATH'] = '/tmp';

$_ENV['SESSION_DRIVER'] = 'cookie';
$_SERVER['SESSION_DRIVER'] = 'cookie';

$_ENV['DB_CONNECTION'] = 'pgsql';
$_SERVER['DB_CONNECTION'] = 'pgsql';

// Forward permintaan ke index public
require __DIR__ . '/../public/index.php';