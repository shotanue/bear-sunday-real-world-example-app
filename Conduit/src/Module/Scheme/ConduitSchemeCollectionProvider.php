<?php
declare(strict_types=1);

namespace Acme\Conduit\Module\Scheme;

use BEAR\Resource\Annotation\AppName;
use BEAR\Resource\AppAdapter;
use BEAR\Resource\HttpAdapter;
use BEAR\Resource\SchemeCollection;
use Ray\Di\InjectorInterface;
use Ray\Di\ProviderInterface;

final class ConduitSchemeCollectionProvider implements ProviderInterface
{
    /**
     * @var string
     */
    private $appName;

    /**
     * @var InjectorInterface
     */
    private $injector;

    /**
     * @param string $appName
     *
     * @param InjectorInterface $injector
     * @AppName("appName")
     */
    public function __construct($appName, InjectorInterface $injector)
    {
        $this->appName = $appName;
        $this->injector = $injector;
    }

    /**
     * Return instance
     *
     * @return SchemeCollection
     */
    public function get(): SchemeCollection
    {
        $schemeCollection = new SchemeCollection;
        $schemeCollection->scheme('page')->host('self')->toAdapter(new AppAdapter($this->injector, $this->appName));
        $schemeCollection->scheme('app')->host('self')->toAdapter(new AppAdapter($this->injector, $this->appName));
        $schemeCollection->scheme('user')->host('self')->toAdapter(new AppAdapter($this->injector, $this->appName));
        $schemeCollection->scheme('article')->host('self')->toAdapter(new AppAdapter($this->injector, $this->appName));
        $schemeCollection->scheme('http')->host('self')->toAdapter(new HttpAdapter($this->injector));

        return $schemeCollection;
    }
}
