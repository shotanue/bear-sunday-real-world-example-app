<?php
declare(strict_types=1);

namespace Acme\Conduit\Module\ConduitAuth;

use Acme\Conduit\Module\ConduitAuth\Login\Login;
use Ray\Aop\MethodInterceptor;
use Ray\Aop\MethodInvocation;
use Throwable;

final class ConduitAuthInterceptor implements MethodInterceptor
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
     * {@inheritdoc}
     * @throws Throwable
     */
    public function invoke(MethodInvocation $invocation)
    {
        ($this->login)();
        return $invocation->proceed();
    }
}