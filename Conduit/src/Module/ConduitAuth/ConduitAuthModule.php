<?php
declare(strict_types=1);

namespace Acme\Conduit\Module\ConduitAuth;

use Acme\Conduit\Module\ConduitAuth\Login\Login;
use Acme\Conduit\Module\ConduitAuth\Request\RequestProvider;
use Acme\Conduit\Module\ConduitAuth\Token\Token;
use Acme\Conduit\Module\ConduitAuth\Token\TokenProvider;
use Aura\Web\Request;
use Ray\Di\AbstractModule;

final class ConduitAuthModule extends AbstractModule
{
    /**
     * Configure binding
     */
    protected function configure(): void
    {
        $this->bind(Request::class)->toProvider(RequestProvider::class);
        $this->bind(Token::class)->toProvider(TokenProvider::class);
        $this->bind(Login::class);
    }
}