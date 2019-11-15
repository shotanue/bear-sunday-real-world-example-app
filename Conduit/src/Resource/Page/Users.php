<?php
declare(strict_types=1);

namespace Acme\Conduit\Resource\Page;

use Acme\Conduit\Module\ConduitAuth\Annotation\ConduitAuth;
use Acme\Conduit\Module\ConduitAuth\AuthService\AuthServiceInterface;
use BEAR\Resource\ResourceObject;
use BEAR\Sunday\Inject\ResourceInject;

/**
 * Class Users
 * @package Acme\Conduit\Resource\Page
 */
class Users extends ResourceObject
{
    use ResourceInject;

    /**
     * @var AuthServiceInterface
     */
    private $authService;

    public function __construct(AuthServiceInterface $authService)
    {
        $this->authService = $authService;
    }

    /**
     * @ConduitAuth
     */
    public function onGet(): ResourceObject
    {
        $id = $this->authService->getUserId();
        $this->resource->get('app://self/users', compact('id'));
        return $this;
    }
}