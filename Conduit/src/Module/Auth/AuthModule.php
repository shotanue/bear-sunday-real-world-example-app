<?php
declare(strict_types=1);

namespace Acme\Conduit\Module\Auth;

use BEAR\Package\AbstractAppModule;
use BEAR\Resource\ResourceObject;
use ReflectionException;

final class AuthModule extends AbstractAppModule
{
    /**
     * @inheritDoc
     * @throws ReflectionException
     */
    protected function configure(): void
    {
        $this->bind(Uuid::class)->toProvider(UuidProvider::class);
        $this->bind(Jwt::class)->toProvider(JwtProvider::class);

        $this->bindInterceptor(
            $this->matcher->logicalAnd(
                $this->matcher->logicalAnd(
                    $this->matcher->logicalNot(
                        $this->matcher->annotatedWith(PublicDomain::class)
                    ),
                    $this->matcher->subclassesOf(ResourceObject::class)
                ),
                $this->matcher->startsWith('Acme')
            ),
            $this->matcher->startsWith('on'),
            [AuthInterceptor::class]
        );
    }
}