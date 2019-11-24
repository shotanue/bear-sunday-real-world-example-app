<?php
declare(strict_types=1);
namespace Test\Conduit\Domain\Auth;

use Acme\Conduit\Domain\Auth\Jwt;
use PHPUnit\Framework\TestCase;

class JwtTest extends TestCase
{
    public function testParseAndEncode() : void
    {
        $uuid = '12345-abc-xyz';
        $expected = compact('uuid');

        $authorizationHeader = 'Bearer ' . Jwt::encode($expected);

        $actual = Jwt::parse($authorizationHeader);

        $this->assertSame($expected, $actual);
    }
}
