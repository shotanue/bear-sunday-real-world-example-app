<?php
declare(strict_types=1);

namespace Acme\Conduit\Module\ConduitAuth\Request;

use Aura\Web\Request;
use Aura\Web\WebFactory;
use Ray\Di\ProviderInterface;
use Ray\TestDouble\Annotation\Fakeable;


/**
 * @Fakeable
 * @see FakeRequestProvider
 */
class RequestProvider implements ProviderInterface
{

    /**
     * @inheritDoc
     */
    public function get(): Request
    {
        return (new WebFactory($GLOBALS))->newRequest();
    }
}