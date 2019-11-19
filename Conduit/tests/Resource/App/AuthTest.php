<?php
declare(strict_types=1);

use Acme\Conduit\ConduitTest;
use Acme\Conduit\Module\Error\ValidationErrorException;
use Aura\Sql\ExtendedPdoInterface;
use BEAR\Resource\ResourceInterface;
use PHPUnit\Framework\TestCase;

/**
 * Class AuthTest
 */
class AuthTest extends TestCase
{
    private $uuid;

    public static function setUpBeforeClass(): void
    {
        parent::setUpBeforeClass();
        /** @var $epdo ExtendedPdoInterface */
        $pdo = ConduitTest::createAppInjector()->getInstance(ExtendedPdoInterface::class);

        $pdo->query('truncate table auth');
    }

    public static function tearDownAfterClass(): void
    {
        parent::tearDownAfterClass();
        /** @var $epdo ExtendedPdoInterface */
        $pdo = ConduitTest::createAppInjector()->getInstance(ExtendedPdoInterface::class);

        $pdo->query('truncate table auth');
    }

    public function testOnPost(): void
    {
        /** @var $resource ResourceInterface */
        $resource = ConduitTest::createAppInjector()->getInstance(ResourceInterface::class);
        $user = [
            'email' => 'test@test.com',
            'password' => 'sample-password'
        ];
        $ro = $resource->post('app://self/auth', compact('user'));
        $this->uuid = $ro->body['auth']['uuid'];
        $this->assertSame(201, $ro->code);
    }

    /**
     * @depends testOnPost
     */
    public function testCannotRegisterSameUser(): void
    {
        $this->expectException(ValidationErrorException::class);
        /** @var $resource ResourceInterface */
        $resource = ConduitTest::createAppInjector()->getInstance(ResourceInterface::class);
        $user = [
            'email' => 'test@test.com',
            'password' => 'hoge-password'
        ];

        $ro = $resource->post('app://self/auth', compact('user'));

        $this->assertSame(422, $ro->code);
    }
}
