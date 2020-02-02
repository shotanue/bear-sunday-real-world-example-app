<?php
declare(strict_types=1);
namespace Acme\Conduit\Resource\Page;

use Acme\Conduit\Module\Auth\PublicDomain;
use BEAR\Resource\ResourceObject;

class Index extends ResourceObject
{
    /**
     * @PublicDomain
     *
     * @param string $name
     *
     * @return ResourceObject
     */
    public function onGet(string $name = 'BEAR.Sunday') : ResourceObject
    {
        $this->body = [
            'greeting' => 'Hello ' . $name,
        ];

        return $this;
    }
}
