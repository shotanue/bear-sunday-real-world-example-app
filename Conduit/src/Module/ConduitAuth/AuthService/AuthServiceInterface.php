<?php
declare(strict_types=1);

namespace Acme\Conduit\Module\ConduitAuth\AuthService;

use Acme\Conduit\Module\ConduitAuth\Exceptions\UnauthorizedException;

/**
 * Interface AuthServiceInterface
 * @package Acme\Conduit\Module\ConduitAuth\AuthService
 */
interface AuthServiceInterface
{
    /**
     * @return int
     * @throws UnauthorizedException
     */
    public function getUserId(): int;
}