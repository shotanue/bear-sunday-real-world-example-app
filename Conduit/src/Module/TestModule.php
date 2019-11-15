<?php
declare(strict_types=1);

namespace Acme\Conduit\Module;

use BEAR\Package\AbstractAppModule;
use Ray\AuraSqlModule\AuraSqlModule;
use Ray\TestDouble\TestDoubleModule;

class TestModule extends AbstractAppModule
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this->install(
            new AuraSqlModule(
                getenv('DB_DSN') . '_test',
                getenv('DB_USER'),
                getenv('DB_PASS'),
                getenv('DB_SLAVE')
            )
        );

        $this->install(new TestDoubleModule);
    }
}