<?php

// Paksa environment variabel Vercel Serverless
putenv('LOG_CHANNEL=stderr');
$_ENV['LOG_CHANNEL'] = 'stderr';

putenv('VIEW_COMPILED_PATH=/tmp');
$_ENV['VIEW_COMPILED_PATH'] = '/tmp';

putenv('SESSION_DRIVER=cookie');
$_ENV['SESSION_DRIVER'] = 'cookie';

putenv('DB_CONNECTION=pgsql');
$_ENV['DB_CONNECTION'] = 'pgsql';

// Forward permintaan ke entry point Laravel
require __DIR__ . '/../public/index.php';