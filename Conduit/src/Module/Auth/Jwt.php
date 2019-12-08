<?php
declare(strict_types=1);

namespace Acme\Conduit\Module\Auth;

final class Jwt
{
    private const KEY = 'key'; // Conduit is not for production.

    private $uuid;

    private function __construct(array $map)
    {
        $this->uuid = $map['uuid'];
    }

    public static function create(array $payload): self
    {
        return new self($payload);
    }

    public static function parse(string $authorization): self
    {
        if ($authorization === '') {
            throw new UnAuthorizedException('No JWT string given');
        }

        $jwt = explode(' ', $authorization)[1] ?? '';

        $payload = (array)\Firebase\JWT\JWT::decode($jwt, self::KEY, ['HS256']);
        return new self($payload);
    }

    public function encode(): string
    {
        $payload = [
            'uuid' => $this->uuid
        ];

        return \Firebase\JWT\JWT::encode($payload, self::KEY);
    }

    public function isExpired(): bool
    {
        return false;
    }

    public function toUuid(): Uuid
    {
        return new Uuid($this->uuid);
    }

    public function validate(): void
    {
        if ($this->isExpired()) {
            throw new UnAuthorizedException('JWT expired');
        }
    }
}
