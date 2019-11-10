<?php
declare(strict_types=1);

namespace Acme\Conduit\Module\ConduitAuth;

use Aura\Web\Request;
use Aura\Web\WebFactory;
use Ray\Di\ProviderInterface;

final class RequestProvider implements ProviderInterface
{

    /**
     * @inheritDoc
     */
    public function get(): Request
    {
        return (new WebFactory($GLOBALS))->newRequest();
    }
}