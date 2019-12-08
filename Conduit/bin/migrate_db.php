<?php
declare(strict_types=1);

require dirname(__DIR__) . '/autoload.php';
require_once dirname(__DIR__) . '/env.php';

$dbHost = getenv('DB_HOST');
$dbUser = getenv('DB_USER');
$dbPass = getenv('DB_PASS');
$dbName = sprintf($argv[1] === 'test' ? '%s_test' : '%s', getenv('DB_NAME'));

$createPdo = fn() => new PDO(sprintf('mysql:host=%s', $dbHost), $dbUser, $dbPass);
$migrate = fn($resourceName) => passthru(
    "mysqldef -u=${dbUser} -p=${dbPass} -h=${dbHost} ${dbName}_${resourceName} < var/schema/${resourceName}.schema.sql"
);

$createSchema = function (string $resourceName) use ($dbName, $createPdo, $migrate) {
    ($createPdo)()->exec("CREATE DATABASE IF NOT EXISTS {$dbName}_${resourceName}");
    ($migrate)($resourceName);
};

array_map(fn(string $resourceName) => ($createSchema)($resourceName), [
    'user',
    'article',
]);
