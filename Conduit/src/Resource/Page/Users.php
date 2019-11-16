<?php
declare(strict_types=1);

namespace Acme\Conduit\Resource\Page;

use Acme\Conduit\Module\ConduitAuth\Annotation\ConduitAuth;
use Acme\Conduit\Module\ConduitAuth\AuthService\AuthServiceInterface;
use BEAR\Resource\Annotation\JsonSchema;
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

    /**
     * @JsonSchema(key="user", schema="user.json", params="user.post.json")
     *
     * @param string $email
     * @param string $username
     * @param string $bio
     * @param string $image
     * @return ResourceObject
     */
    public function onPost(
        string $email,
        string $username = '',
        string $bio = '',
        string $image = ''
    ): ResourceObject {
        $newUser = $this->resource->post('app://self/users', compact('email', 'username', 'bio', 'image'));

        $this->body = $newUser;

        return $this;
    }
}