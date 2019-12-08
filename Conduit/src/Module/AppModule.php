<?php
declare(strict_types=1);

namespace Acme\Conduit\Module;

use Acme\Conduit\Module\Auth\AuthModule;
use Acme\Conduit\Module\Scheme\ConduitSchemeCollectionModule;
use BEAR\Package\AbstractAppModule;
use BEAR\Package\PackageModule;
use BEAR\Package\Provide\Router\AuraRouterModule;
use BEAR\Resource\Module\JsonSchemaModule;
use PDO;
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
        $pdoOptions = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false
        ];
        $this->install(
            new AuraSqlModule(
                getenv('DB_DSN'),
                getenv('DB_USER'),
                getenv('DB_PASS'),
                getenv('DB_SLAVE'),
                $pdoOptions
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

        $this->install(new AuthModule);

        $this->install(new AuraRouterModule($appDir . '/var/conf/aura.route.php'));
        $this->install(new ValidateModule);
        $this->install(new ConduitSchemeCollectionModule);
        $this->install(new PackageModule);
    }
}
