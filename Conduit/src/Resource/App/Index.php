<?php
declare(strict_types=1);
namespace Acme\Conduit\Resource\App;

use BEAR\RepositoryModule\Annotation\Cacheable;
use BEAR\Resource\ResourceObject;

/**
 * @Cacheable(expirySecond=30)
 */
class Index extends ResourceObject
{
    public function onGet() : ResourceObject
    {
        $this->body = [
            'home' => ['index']
        ];

        return $this;
    }
}
