<?php
declare(strict_types=1);

require dirname(__DIR__) . '/autoload.php';
require_once dirname(__DIR__) . '/env.php';

// dir
chdir(dirname(__DIR__));
passthru('rm -rf var/tmp/*');
passthru('chmod 775 var/tmp');
passthru('chmod 775 var/log');

// db
//$dsn = 'mysql:host=' . getenv('DB_HOST');
//$userName = getenv('DB_USER');
//$pass = getenv('DB_PASS');

//$pdo = new PDO($dsn, $userName, $pass);
//$pdo->exec('CREATE DATABASE IF NOT EXISTS ' . getenv('DB_NAME'));
//$pdo->exec('CREATE DATABASE IF NOT EXISTS ' . getenv('DB_NAME') . '_test');
