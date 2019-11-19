<?php
declare(strict_types=1);

namespace Acme\Conduit\Module\Error;

use PHPUnit\Framework\TestCase;

class ParseJsonSchemaMsgTest extends TestCase
{

    public function testParse(): void
    {
        $sample = '[email] Invalid email; [username] Must be at least 1 characters long; by /var/app/var/json_validate/users.post.json';
        $actual = ParseJsonSchemaMsg::parse($sample);

        $expected = [
            'email' => 'Invalid email',
            'username' => 'Must be at least 1 characters long',
        ];

        $this->assertSame($expected, $actual);
    }
}
