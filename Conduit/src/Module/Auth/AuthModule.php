<?php
declare(strict_types=1);
namespace Acme\Conduit\Module\Auth;

use BEAR\Resource\ResourceObject;
use Ray\Di\AbstractModule;
use ReflectionException;

final class AuthModule extends AbstractModule
{
    /**
     * {@inheritdoc}
     *
     * @throws ReflectionException
     */
    protected function configure() : void
    {
        $this->bind(JwtProvider::class);
        $this->bindInterceptor(
            $this->matcher->subclassesOf(ResourceObject::class),
            $this->matcher->startsWith('on'),
            [AuthInterceptor::class]
        );
    }
}
