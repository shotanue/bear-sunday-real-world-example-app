<?php
declare(strict_types=1);

namespace Acme\Conduit\Resource\App;

use BEAR\Resource\ResourceObject;

/**
 * Class Users
 */
class UserRegisterRegistered extends ResourceObject
{
    public function onPost(UserRegistrationRequest $input): ResourceObject
    {
        // QueryMaterializerでクエリ用データをインサートする
        $this->resource->post('queryMaterializer://self/users', $input);

        return $this;
    }
}
