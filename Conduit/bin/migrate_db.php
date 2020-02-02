<?php
declare(strict_types=1);

require dirname(__DIR__) . '/autoload.php';
require_once dirname(__DIR__) . '/env.php';

$dbHost = getenv('DB_HOST');
$dbUser = getenv('DB_USER');
$dbPass = getenv('DB_PASS');
$dbName = sprintf($argv[1] === 'test' ? '%s_test' : '%s', getenv('DB_NAME'));

$pdo = new PDO(sprintf('mysql:host=%s', $dbHost), $dbUser, $dbPass);
$pdo->exec("CREATE DATABASE IF NOT EXISTS {$dbName}");
passthru('cat var/schema/*.schema.sql > /tmp/tmp.schema.sql');
passthru("mysqldef -u=${dbUser} -p=${dbPass} -h=${dbHost} ${dbName} < /tmp/tmp.schema.sql");
