<?php
declare(strict_types=1);

namespace Acme\Conduit\Module\ConduitAuth\AuthService;

use Acme\Conduit\Module\ConduitAuth\Login\Login;

/**
 * Class AuthService
 * @package Acme\Conduit\Module\ConduitAuth\AuthService
 */
final class AuthService implements AuthServiceInterface
{
    /**
     * @var Login
     */
    private $login;

    /**
     * AuthService constructor.
     *
     * @param callable $login fn() => int
     */
    public function __construct(callable $login)
    {
        $this->login = $login;
    }

    /**
     * @inheritDoc
     */
    public function getUserId(): int
    {
        return ($this->login)();
    }
}