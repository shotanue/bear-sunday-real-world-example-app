<?php
declare(strict_types=1);

namespace Acme\Conduit\Module\ConduitAuth\Token;

use Acme\Conduit\ConduitTest;
use Acme\Conduit\Module\ConduitAuth\Request\FakeRequestProvider;
use Acme\Conduit\Module\ConduitAuth\Request\RequestProvider;
use Aura\Web\Request;
use PHPUnit\Framework\TestCase;

class TokenProviderTest extends TestCase
{
    /**
     * @var Request
     */
    private $request;

    protected function setUp(): void
    {
        parent::setUp();
        /** @var $requestProvider RequestProvider */
        $requestProvider = ConduitTest::createAppInjector()->getInstance(RequestProvider::class);
        $request = $requestProvider->get();

        $this->assertSame(
            FakeRequestProvider::FAKE_AUTH_HEADER,
            $request->headers->get('authorization')
        );
        $this->request = $request;
    }

    public function testGet(): void
    {
        $actualToken = (new TokenProvider($this->request))->get();
        $this->assertSame(
            FakeRequestProvider::FAKE_TOKEN,
            $actualToken->asString()
        );
    }
}
