<?php
declare(strict_types=1);
namespace Acme\Conduit\Module\Auth;

use InvalidArgumentException;
use stdClass;

final class Jwt
{
    private const SECRET = 'secretKey'; // Conduit is not for production.
    private stdClass $payload;

    public function __construct($payload)
    {
        $this->payload = $payload;
    }

    public static function encode(array $payload) : string
    {
        if (! isset($payload['uuid']) || $payload === '') {
            throw new InvalidArgumentException('no uuid found in payload');
        }

        return \Firebase\JWT\JWT::encode($payload, self::SECRET);
    }

    public static function decode(string $jwtString) : self
    {
        if ($jwtString === '') {
            throw new UnAuthorizedException('No JWT string given');
        }

        $jwt = explode(' ', $jwtString)[1] ?? '';

        return new self(
            \Firebase\JWT\JWT::decode($jwt, self::SECRET, ['HS256'])
        );
    }

    public function isExpired() : bool
    {
        // todo implement
        return false;
    }

    public function toUuid() : string
    {
        return $this->payload->uuid;
    }

    public function validate() : void
    {
        if ($this->isExpired()) {
            throw new UnAuthorizedException('JWT expired');
        }
    }
}
