<?php
declare(strict_types=1);

namespace Acme\Conduit\Module\ConduitAuth\Token;

use Acme\Conduit\Module\ConduitAuth\Exceptions\ForbiddenException;
use Aura\Web\Request;
use Ray\Di\ProviderInterface;

final class TokenProvider implements ProviderInterface
{
    /**
     * @var Request
     */
    private $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Get object
     */
    public function get(): Token
    {
        $authorization = $this->request->headers->get('authorization', '');
        if ($authorization === '') {
            return new Token($authorization);
        }

        $needle = 'Token ';
        if (strpos($authorization, $needle) !== 0) {
            throw new ForbiddenException('Invalid format');
        }

        return new Token(substr($authorization, strlen($needle)));
    }
}