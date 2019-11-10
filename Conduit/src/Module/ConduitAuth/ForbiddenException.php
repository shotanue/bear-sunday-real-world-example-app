<?php
declare(strict_types=1);

namespace Acme\Conduit\Module\ConduitAuth;

use BEAR\Resource\Exception\ExceptionInterface;
use InvalidArgumentException;

final class ForbiddenException extends InvalidArgumentException implements ExceptionInterface
{
}