<?php
declare(strict_types=1);

namespace Acme\Conduit\Module\ConduitAuth\Token;

use Acme\Conduit\Module\ConduitAuth\Exceptions\UnauthorizedException;

final class Token
{
    /**
     * @var string
     */
    private $token;

    public function __construct(string $token)
    {
        $this->token = $token;
    }

    public static function create(): string
    {
        // todo use jwt token
        $TOKEN_LENGTH = 16;//16*2=32byte
        $bytes = openssl_random_pseudo_bytes($TOKEN_LENGTH);
        return bin2hex($bytes);
    }

    /**
     * @return string
     */
    public function asString(): string
    {
        if ($this->token === '') {
            throw new UnauthorizedException('No token given');
        }
        return $this->token;
    }
}