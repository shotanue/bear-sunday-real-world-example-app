<?php
declare(strict_types=1);

namespace Acme\Conduit\Resource\App\Auth;

use BEAR\Resource\ResourceObject;

final class Verify extends ResourceObject
{
    public function __construct()
    {
    }

    public function onGet(): ResourceObject
    {
        return $this;
    }
}