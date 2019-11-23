<?php
declare(strict_types=1);
namespace Acme\Conduit\Resource\App;

use BEAR\Resource\ResourceObject;

/**
 * Class Users
 */
class Users extends ResourceObject
{
    public function onGet() : ResourceObject
    {
        $this->body = [
            'user' => ['hello']
        ];

        return $this;
    }
}
