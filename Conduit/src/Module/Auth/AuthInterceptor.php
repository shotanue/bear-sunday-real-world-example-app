<?php
declare(strict_types=1);

namespace Acme\Conduit\Module\Auth;

use Ray\Aop\MethodInterceptor;
use Ray\Aop\MethodInvocation;

final class AuthInterceptor implements MethodInterceptor
{
    public function __construct(Jwt $jwt)
    {
        // validate jwt in JwtProvider
    }

    /**
     * @inheritDoc
     */
    public function invoke(MethodInvocation $invocation)
    {
    }
}