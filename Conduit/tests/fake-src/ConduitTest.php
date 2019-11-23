<?php
declare(strict_types=1);
namespace Acme\Conduit;

use BEAR\Package\AppInjector;

final class ConduitTest
{
    private const PROJECT_NAME = 'Acme\Conduit';

    /** @noinspection PhpUndefinedClassInspection */
    public static function createAppInjector() : AppInjector
    {
        /* @noinspection PhpUndefinedClassInspection */
        return new AppInjector(self::PROJECT_NAME, 'test-app');
    }
}
