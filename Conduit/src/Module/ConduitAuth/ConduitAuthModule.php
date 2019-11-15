<?php
declare(strict_types=1);

namespace Acme\Conduit\Module\ConduitAuth;

use Acme\Conduit\Module\ConduitAuth\Annotation\ConduitAuth;
use Acme\Conduit\Module\ConduitAuth\AuthService\AuthServiceInterface;
use Acme\Conduit\Module\ConduitAuth\AuthService\AuthServiceProvider;
use Acme\Conduit\Module\ConduitAuth\Login\Login;
use Acme\Conduit\Module\ConduitAuth\Request\RequestProvider;
use Acme\Conduit\Module\ConduitAuth\Token\Token;
use Acme\Conduit\Module\ConduitAuth\Token\TokenProvider;
use Aura\Web\Request;
use BEAR\Resource\ResourceObject;
use Ray\Di\AbstractModule;

final class ConduitAuthModule extends AbstractModule
{
    /**
     * Configure binding
     * @throws \ReflectionException
     */
    protected function configure(): void
    {
        $this->bind(Request::class)->toProvider(RequestProvider::class);
        $this->bind(Token::class)->toProvider(TokenProvider::class);
        $this->bind(Login::class);

        $this->bind(AuthServiceInterface::class)->toProvider(AuthServiceProvider::class);

        $this->bindInterceptor(
            $this->matcher->subclassesOf(ResourceObject::class),
            $this->matcher->annotatedWith(ConduitAuth::class),
            [ConduitAuthInterceptor::class]
        );
    }
}