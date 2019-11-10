<?php
declare(strict_types=1);

namespace Acme\Conduit\Resource\App;

use Acme\Conduit\Module\ConduitAuth\ConduitAuth;
use Acme\Conduit\Module\Error\ValidationErrorException;
use BEAR\Resource\Annotation\JsonSchema;
use BEAR\Resource\ResourceObject;
use Koriym\HttpConstants\StatusCode;
use Ray\AuraSqlModule\Annotation\Transactional;
use Ray\Di\Di\Named;
use Ray\Query\Annotation\Query;
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
    private $findByEmail;
    /**
     * @var callable
     */
    private $findByUsername;

    /**
     * @Named("registerUser=register_user, findByEmail=find_by_email, findByUsername=find_by_username")
     * @param callable $registerUser
     * @param callable $findByEmail
     * @param callable $findByUsername
     */
    public function __construct(callable $registerUser, callable $findByEmail, callable $findByUsername)
    {
        $this->registerUser = $registerUser;
        $this->findByEmail = $findByEmail;
        $this->findByUsername = $findByUsername;
    }

    /**
     */
    public function onGet(): ResourceObject
    {
        $this->body = [
            'tmp' => 'test'
        ];
        return $this;
    }

    /**
     * @JsonSchema(key="user", schema="user.json", params="user.post.json")
     *
     * @Valid
     * @Transactional
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
        $token = 'tmp-token';
        $user = compact('email', 'token', 'username', 'bio', 'image');

        ($this->registerUser)($user);

        $this->code = StatusCode::OK;

        $this->body = compact('user');

        return $this;
    }

    /**
     * @OnValidate
     * @param string $email
     * @param string $username
     * @return Validation
     */
    public function onValidate(
        string $email,
        string $username = ''
    ): Validation {
        $validation = new Validation();
        if (($this->findByEmail)(compact('email'))) {
            $validation->addError('email', 'has already taken');
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