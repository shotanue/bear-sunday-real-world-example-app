<?php
declare(strict_types=1);

namespace Acme\Conduit\Module\Auth;

use Ray\Di\ProviderInterface;

final class JwtProvider implements ProviderInterface
{
    /**
     * @inheritDoc
     */
    public function get(): Jwt
    {
        $jwt = Jwt::parse($_SERVER['HTTP_AUTHORIZATION'] ?? '');
        $jwt->validate();

        return $jwt;
    }
}