<?php
declare(strict_types=1);

namespace Acme\Conduit\Module\ConduitAuth\Exceptions;

use BEAR\Resource\Exception\ExceptionInterface;
use InvalidArgumentException;

final class UnauthorizedException extends InvalidArgumentException implements ExceptionInterface
{
}