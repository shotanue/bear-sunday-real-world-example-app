<?php
declare(strict_types=1);
namespace Acme\Conduit\Module\Scheme;

use BEAR\Resource\SchemeCollectionInterface;
use Ray\Di\AbstractModule;

final class ConduitSchemeCollectionModule extends AbstractModule
{
    /**
     * {@inheritdoc}
     */
    protected function configure() : void
    {
        $this->bind(SchemeCollectionInterface::class)->toProvider(ConduitSchemeCollectionProvider::class);
    }
}
