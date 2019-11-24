<?php
declare(strict_types=1);

namespace Acme\Conduit\Resource\QueryMaterializer;

use BEAR\Resource\ResourceObject;

class Users extends ResourceObject
{
    public function __construct(callable $createUserProfile)
    {
    }

    public function onPost(): ResourceObject
    {
        // QueryProcessor用にデータを用意する
        // User関連はひとまずDBで？
        // ArticleはElasticSearchとかに入れてみたいけど
        return $this;
    }
}
