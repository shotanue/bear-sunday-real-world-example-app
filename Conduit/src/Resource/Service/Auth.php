<?php
declare(strict_types=1);

namespace Acme\Conduit\Resource\App;

use BEAR\Resource\ResourceObject;

class Auth extends ResourceObject
{
    /**
     * @var AuthRepository
     */
    private $authRepository;

    public function __construct(AuthRepository $authRepository)
    {
        $this->authRepository = $authRepository;
    }

    public function onPost($email, $password)
    {
        // DDDライクな実装に
    }
}
