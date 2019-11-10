<?php
declare(strict_types=1);

namespace Acme\Conduit\Resource\Page;

use Acme\Conduit\Module\ConduitAuth\ConduitAuth;
use BEAR\Resource\ResourceObject;
use BEAR\Sunday\Inject\ResourceInject;

class Users extends ResourceObject
{
    use ResourceInject;

    /**
     * @ConduitAuth
     */
    public function onGet(): ResourceObject
    {
        // todo get token or user.id by ConduitAuth, then fetch user from user table;
        $id = 1;
        $this->resource->get('app://self/users', compact('id'));
        return $this;
    }
}