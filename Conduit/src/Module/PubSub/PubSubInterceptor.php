<?php
declare(strict_types=1);

namespace Acme\Conduit\Module\PubSub;

use Ray\Aop\MethodInterceptor;
use Ray\Aop\MethodInvocation;

final class PubSubInterceptor implements MethodInterceptor
{
    /**
     * @inheritDoc
     */
    public function invoke(MethodInvocation $invocation)
    {
        return $invocation->proceed();
    }
}