<?php
declare(strict_types=1);
namespace Acme\Conduit\Domain\Auth;

final class Jwt
{
    private const KEY = 'key'; // Conduit is not for production.

    public static function encode(array $payload) : string
    {
        return \Firebase\JWT\JWT::encode($payload, self::KEY);
    }

    public static function parse(string $authorization) : array
    {
        $jwt = explode(' ', $authorization)[1] ?? '';

        return (array) \Firebase\JWT\JWT::decode($jwt, self::KEY, ['HS256']);
    }
}
