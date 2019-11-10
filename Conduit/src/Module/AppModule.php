<?php

namespace Acme\Conduit\Module;

use Acme\Conduit\Module\Error\OverrideErrorPageFactoryModule;
use BEAR\Package\AbstractAppModule;
use BEAR\Package\PackageModule;
use BEAR\Package\Provide\Router\AuraRouterModule;
use BEAR\Resource\Module\JsonSchemaModule;
use Ray\AuraSqlModule\AuraSqlModule;
use Ray\IdentityValueModule\IdentityValueModule;
use Ray\Query\SqlQueryModule;
use Ray\Validation\ValidateModule;

class AppModule extends AbstractAppModule
{
    /**
     * {@inheritdoc}
     */
    protected function configure(): void
    {
        $appDir = $this->appMeta->appDir;
        /** @noinspection PhpIncludeInspection */
        require_once $appDir . '/env.php';
        $this->install(
            new AuraSqlModule(
                getenv('DB_DSN'),
                getenv('DB_USER'),
                getenv('DB_PASS'),
                getenv('DB_SLAVE')
            )
        );
        $this->install(new SqlQueryModule($appDir . '/var/sql'));
        $this->install(new IdentityValueModule);
        $this->install(
            new JsonSchemaModule(
                $appDir . '/var/json_schema',
                $appDir . '/var/json_validate'
            )
        );

        $this->install(new AuraRouterModule($appDir . '/var/conf/aura.route.php'));
        $this->install(new ValidateModule);

        // override default modules defined in PackageModule
        $this->install(new OverrideErrorPageFactoryModule);

        $this->install(new PackageModule);

    }
}
