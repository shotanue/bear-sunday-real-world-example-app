<?php
declare(strict_types=1);

namespace Acme\Conduit\Module\ConduitAuth\Request;

use Aura\Web\Request;
use Aura\Web\WebFactory;

class FakeRequestProvider extends RequestProvider
{
    private const BEARER = 'Token ';
    public const FAKE_TOKEN = 'fake-token-xxx-123';
    public const FAKE_AUTH_HEADER = self::BEARER . self::FAKE_TOKEN;

    /**
     * @inheritDoc
     */
    public function get(): Request
    {
        $fakeGlobals = [
            '_SERVER' => [
                'HTTP_AUTHORIZATION' => self::FAKE_AUTH_HEADER
            ]
        ];
        return (new WebFactory($fakeGlobals))->newRequest();
    }
}