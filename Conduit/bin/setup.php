<?php
declare(strict_types=1);

require dirname(__DIR__) . '/autoload.php';
require_once dirname(__DIR__) . '/env.php';

// dir
chdir(dirname(__DIR__));
passthru('rm -rf var/tmp/*');
passthru('chmod 775 var/tmp');
passthru('chmod 775 var/log');
