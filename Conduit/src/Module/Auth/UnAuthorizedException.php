<?php
declare(strict_types=1);

namespace Acme\Conduit\Module\Auth;

use InvalidArgumentException;

final class UnAuthorizedException extends InvalidArgumentException
{
}