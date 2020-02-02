<?php
declare(strict_types=1);
namespace Test\Conduit\Module\Auth;

use Acme\Conduit\Module\Auth\Jwt;
use PHPUnit\Framework\TestCase;

class JwtTest extends TestCase
{
    public function testParseAndEncode() : void
    {
        $expected = ['uuid' => '12345-abc-xyz'];
        $jwt = Jwt::encode($expected);

        $actual = Jwt::decode('Bearer ' . $jwt);

        $this->assertSame($expected['uuid'], (string) $actual->toUuid());
    }
}
