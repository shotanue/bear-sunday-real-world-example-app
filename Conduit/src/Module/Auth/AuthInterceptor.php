<?php
declare(strict_types=1);

namespace Acme\Conduit\Module\Auth;

use Acme\Conduit\Module\Auth\Annotations\PublicDomain;
use Acme\Conduit\Module\Auth\Annotations\RequireUuid;
use Doctrine\Common\Annotations\Reader;
use Ray\Aop\MethodInterceptor;
use Ray\Aop\MethodInvocation;

final class AuthInterceptor implements MethodInterceptor
{
    private Reader $annotationReader;
    private JwtProvider $jwtProvider;

    public function __construct(Reader $reader, JwtProvider $jwtProvider)
    {
        $this->annotationReader = $reader;
        $this->jwtProvider = $jwtProvider;
    }

    /**
     * {@inheritdoc}
     */
    public function invoke(MethodInvocation $invocation)
    {
        $isPrivateDomain = $this->annotationReader->getMethodAnnotation(
                $invocation->getMethod(),
                PublicDomain::class
            ) === null;

        if ($isPrivateDomain) {
            $jwt = $this->jwtProvider->get();
            $jwt->validate();
            $this->swapUuidParamIfRequired($invocation, $jwt);
        }

        return $invocation->proceed();
    }

    /** @noinspection OnlyWritesOnParameterInspection */
    private function swapUuidParamIfRequired(MethodInvocation $invocation, Jwt $jwt): void
    {
        /** @var $requireUuid RequireUuid|null */
        $requireUuid = $this->annotationReader->getMethodAnnotation(
            $invocation->getMethod(),
            RequireUuid::class
        );

        if ($requireUuid !== null) {
            $args = $invocation->getArguments();
            foreach ($invocation->getMethod()->getParameters() as $index => $parameter) {
                if ($parameter->name === 'uuid') {
                    $args[$index] = $jwt->toUuid();
                }
            }
        }
    }
}
