<?php
declare(strict_types=1);

namespace Acme\Conduit\Resource\QueryProcessor;

use BEAR\Resource\ResourceObject;

/**
 * Class Users
 */
class Users extends ResourceObject
{
    /**
     * @var UsersReadModel
     */
    private $query;

    public function __construct(UsersReadModel $query)
    {
        $this->query = $query;
    }

    /**
     * @AuthRequired
     */
    public function onGet(Uuid $uuid): ResourceObject
    {
        $user = $this->query->findByUuid($uuid);
        $this->body = compact('user');
        return $this;
    }
}
