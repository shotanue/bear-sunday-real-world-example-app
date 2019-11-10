<?php
declare(strict_types=1);

namespace Acme\Conduit\Module\ConduitAuth;

use Aura\Web\Request;
use BEAR\Resource\ResourceObject;
use Ray\Di\AbstractModule;
use Ray\Di\Scope;

final class ConduitAuthModule extends AbstractModule
{
    /**
     * Configure binding
     * @throws \ReflectionException
     */
    protected function configure()
    {
        $this->bind(Request::class)->toProvider(RequestProvider::class)->in(Scope::SINGLETON);
        $this->bindInterceptor(
            $this->matcher->subclassesOf(ResourceObject::class),
            $this->matcher->annotatedWith(ConduitAuth::class),
            [ConduitAuthInterceptor::class]
        );
    }
}