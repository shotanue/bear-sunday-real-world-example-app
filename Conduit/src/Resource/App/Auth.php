<?php
declare(strict_types=1);

namespace Acme\Conduit\Resource\App;

use Acme\Conduit\Module\ConduitAuth\Login\Login;
use Acme\Conduit\Module\ConduitAuth\Token\Token;
use Acme\Conduit\Module\Error\ValidationErrorException;
use BEAR\Resource\Annotation\JsonSchema;
use BEAR\Resource\ResourceObject;
use Ray\Di\Di\Named;
use Ray\Validation\Annotation\OnFailure;
use Ray\Validation\Annotation\Valid;
use Ray\Validation\FailureInterface;
use Ray\Validation\Validation;

final class Auth extends ResourceObject
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
     * @Named("$this->registerAuth=register_auth, findAuthByEmail=find_auth_by_email")
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
     * @param string $email
     * @param string $password
     * @return ResourceObject
     */
    public function onPost(string $email, string $password): ResourceObject
    {
        $uuid = Token::create();
        ($this->registerAuth)(compact('uuid', 'email', 'password'));
        return $this;
    }

    public function onValid(string $email): void
    {
        $validation = new Validation();

        if (($this->findAuthByEmail)(compact('email'))) {
            $validation->addError('uuid', 'has already taken');
        }
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
