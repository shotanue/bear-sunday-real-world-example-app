<?php
declare(strict_types=1);

namespace Acme\Conduit\Resource\Page;

use BEAR\Resource\Annotation\JsonSchema;
use BEAR\Resource\ResourceObject;
use BEAR\Sunday\Inject\ResourceInject;
use Ray\AuraSqlModule\Annotation\Transactional;

/**
 * Class Users
 * @package Acme\Conduit\Resource\Page
 */
class Users extends ResourceObject
{
    use ResourceInject;

    /**
     * @param string $uuid
     * @return ResourceObject
     */
    public function onGet(string $uuid): ResourceObject
    {
        $auth = $this->resource->get('app://self/auth');
        $auth = [
            'uuid' => $auth['uuid'],
            'email' => $auth['email'],
        ];

        $user = $this->resource->get('app://self/user', compact('uuid'));

        $this->body = compact('user');
        $this->body['user']['uuid'] = $auth['uuid'];
        $this->body['user']['email'] = $auth['email'];

        return $this;
    }

    /**
     * @JsonSchema(key="user", schema="user.json", params="users.post.json")
     * @Transactional
     *
     * @param string $email
     * @param string $username
     * @param string $bio
     * @param string $image
     * @param string $password
     * @return ResourceObject
     */
    public function onPost(
        string $email,
        string $username,
        string $bio,
        string $image,
        string $password
    ): ResourceObject {
        $ro = $this->resource->post(
            'app://self/auth',
            compact('email', 'password')
        );

        $uuid = $ro->body->uuid;
        $token = $ro->body->token;

        $this->resource->post(
            'app://self/users',
            compact('uuid', 'username', 'bio', 'image')
        );

        $this->body = [
            'user' => compact('username', 'bio', 'image', 'email', 'token')
        ];

        return $this;
    }
}