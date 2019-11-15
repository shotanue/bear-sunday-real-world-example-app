<?php
declare(strict_types=1);

namespace Acme\Conduit\Module\ConduitAuth\Token;

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

    /**
     * @return string
     */
    public function asString(): string
    {
        return $this->token;
    }
}