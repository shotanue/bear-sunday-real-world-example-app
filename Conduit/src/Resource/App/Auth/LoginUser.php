<?php
declare(strict_types=1);

namespace Acme\Conduit\Resource\App\Auth;

use BEAR\Resource\ResourceObject;

final class LoginUser extends ResourceObject
{
    public function __construct()
    {
    }

    public function onGet()
    {
        return $this->body = [
            'uuid' => 5432
        ];
    }
}
