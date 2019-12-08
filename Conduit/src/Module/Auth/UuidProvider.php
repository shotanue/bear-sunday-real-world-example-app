<?php
declare(strict_types=1);

namespace Acme\Conduit\Module\Auth;

use Ray\Di\ProviderInterface;

final class UuidProvider implements ProviderInterface
{
    /**
     * @var Jwt
     */
    private $jwt;

    public function __construct(Jwt $jwt)
    {
        $this->jwt = $jwt;
    }

    /**
     * @inheritDoc
     */
    public function get(): Uuid
    {
        return $this->jwt->toUuid();
    }
}