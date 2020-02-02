<?php
declare(strict_types=1);
namespace Acme\Conduit\Module\Auth;

use Ray\Di\ProviderInterface;

final class JwtProvider implements ProviderInterface
{
    /**
     * {@inheritdoc}
     */
    public function get() : Jwt
    {
        return  Jwt::decode($_SERVER['HTTP_AUTHORIZATION'] ?? '');
    }
}
