<?php
declare(strict_types=1);

namespace Acme\Conduit\Module\ConduitAuth\AuthService;

use Acme\Conduit\Module\ConduitAuth\Login\Login;
use Ray\Di\ProviderInterface;

final class AuthServiceProvider implements ProviderInterface
{
    /**
     * @var Login
     */
    private $login;

    public function __construct(Login $login)
    {
        $this->login = $login;
    }

    /**
     * Get object
     */
    public function get(): AuthService
    {
        return new AuthService(
            $this->login
        );
    }
}