<?php
declare(strict_types=1);

namespace Acme\Conduit\Resource\App;

use Acme\Conduit\Module\Error\ValidationErrorException;
use BEAR\Resource\Annotation\JsonSchema;
use BEAR\Resource\ResourceObject;
use Ray\Di\Di\Named;
use Ray\Validation\Annotation\OnFailure;
use Ray\Validation\Annotation\Valid;
use Ray\Validation\Annotation\OnValidate;
use Ray\Validation\FailureInterface;
use Ray\Validation\Validation;

/**
 * Class Users
 * @package Acme\Conduit\Resource\App\Users
 */
class Users extends ResourceObject
{
    /**
     * @var callable
     */
    private $registerUser;
    /**
     * @var callable
     */
    private $findByUuid;
    /**
     * @var callable
     */
    private $findByUsername;

    /**
     * @JsonSchema(key="user", schema="user.json", params="user.get.json")
     * @Named(registerUser="register_user", findByUuid="find_by_uuid", findByUser="find_by_username")
     *
     * @param callable $registerUser
     * @param callable $findByUuid
     * @param callable $findByUsename
     */
    public function __construct(callable $registerUser, callable $findByUuid, callable $findByUsename)
    {
        $this->registerUser = $registerUser;
        $this->findByUuid = $findByUuid;
        $this->findByUsername = $findByUsename;
    }

    public function onGet(string $uuid): ResourceObject
    {
        $this->body = [
            'user' => ($this->findByUuid)($uuid)
        ];
        return $this;
    }


    /**
     * @JsonSchema(key="user", schema="user.json", params="user.post.json")
     * @Valid
     *
     * @param string $uuid
     * @param string $username
     * @param string $bio
     * @param string $image
     * @return ResourceObject
     */
    public function onPost(
        string $uuid,
        string $username,
        string $bio,
        string $image
    ): ResourceObject {
        $user = compact('username', 'bio', 'image');

        ($this->registerUser)([
            'user' => array_merge($user, compact('uuid'))
        ]);

        $this->body = compact('user');

        return $this;
    }

    /**
     * @OnValidate
     * @param string $uuid
     * @param string $username
     * @return Validation
     */
    public function onValidate(
        string $uuid,
        string $username
    ): Validation {
        $validation = new Validation();

        if (($this->findByUuid)(compact('uuid'))) {
            $validation->addError('uuid', 'has already taken');
        }

        if (($this->findByUsername)(compact('username'))) {
            $validation->addError('username', 'has already taken');
        }

        return $validation;
    }

    /**
     * @OnFailure
     * @param FailureInterface $failure
     * @return ValidationErrorException
     */
    public function onFailure(FailureInterface $failure): ValidationErrorException
    {
        return ValidationErrorException::create($failure);
    }
}