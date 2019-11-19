<?php
declare(strict_types=1);

namespace Acme\Conduit\Resource\App;

use Acme\Conduit\Module\ConduitAuth\Login\Login;
use Acme\Conduit\Module\ConduitAuth\Token\Token;
use Acme\Conduit\Module\Error\ValidationErrorException;
use BEAR\Resource\Annotation\JsonSchema;
use BEAR\Resource\ResourceObject;
use Koriym\HttpConstants\StatusCode;
use Ray\Di\Di\Named;
use Ray\Validation\Annotation\OnFailure;
use Ray\Validation\Annotation\OnValidate;
use Ray\Validation\Annotation\Valid;
use Ray\Validation\FailureInterface;
use Ray\Validation\Validation;

class Auth extends ResourceObject
{
    /**
     * @var callable
     */
    private $registerAuth;
    /**
     * @var callable
     */
    private $findAuthByEmail;

    /**
     * @var Login
     */
    private $login;

    /**
     * @Named("registerAuth=register_auth, findAuthByEmail=find_auth_by_email")
     * @param callable $registerAuth
     * @param callable $findAuthByEmail
     * @param Login $login
     */
    public function __construct(callable $registerAuth, callable $findAuthByEmail, Login $login)
    {
        $this->registerAuth = $registerAuth;
        $this->findAuthByEmail = $findAuthByEmail;
        $this->login = $login;
    }

    /**
     * @JsonSchema(key="auth", params="auth.get.json")
     * @return $this
     */
    public function onGet(): ResourceObject
    {
        $token = ($this->login)();

        $this->body = [
            'uuid' => $token
        ];

        return $this;
    }

    /**
     * @JsonSchema(key="auth", schema="auth.json", params="auth.post.json")
     * @Valid
     * @param array $user
     * @return ResourceObject
     */
    public function onPost(array $user): ResourceObject
    {
        $uuid = Token::create();
        $email = $user['email'];
        $password = $user['password'];

        ($this->registerAuth)(compact('uuid', 'email', 'password'));

        $this->code = StatusCode::CREATED;
        $this->body = [
            'auth' => compact('uuid', 'email')
        ];
        return $this;
    }

    /**
     * @OnValidate
     * @param array $user
     * @return Validation
     */
    public function onValid(array $user): Validation
    {
        $validation = new Validation();
        $email = $user['email'];

        if (($this->findAuthByEmail)(compact('email'))) {
            $validation->addError('uuid', 'has already taken');
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
