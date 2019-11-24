<?php
declare(strict_types=1);

namespace Acme\Conduit\Resource\App;

use BEAR\Resource\ResourceObject;
use Ray\AuraSqlModule\Annotation\Transactional;

/**
 * Class Users
 */
class Users extends ResourceObject
{
    /**
     * @AuthRequired
     */
    public function onGet(Uuid $uuid): ResourceObject
    {
        // CQRSにする
        $this->body = $this->resource->get('queryProcessor://self/user', compact('uuid'));
        return $this;
    }

    /**
     * @Transactional
     */
    public function onPost(UserRegistrationRequest $input): ResourceObject
    {
        // Orchestration的な実装のイメージ
        // 一旦auth,profileで集約としている
        // User作成の実装がこれで良さそうであれば、他のAPIの実装を進める
        $authRo = $this->resource->post('service://self/auth', $input);
        $profileRo = $this->resource->post('service://self/profile', $input);

        if ($authRo->code !== 200 || $profileRo->code !== 200){
            // 各サービスにポスト、200以外だったら例外吐いてロールバックさせる？
        }

        // domain event
        $this->resource->post('event://self/user/registered', $input);

        return $this;
    }
}
