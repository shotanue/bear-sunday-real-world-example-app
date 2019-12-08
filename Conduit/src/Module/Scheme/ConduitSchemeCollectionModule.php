<?php
declare(strict_types=1);

namespace Acme\Conduit\Module\Scheme;

use BEAR\Package\AbstractAppModule;
use BEAR\Resource\SchemeCollectionInterface;

final class ConduitSchemeCollectionModule extends AbstractAppModule
{
    /**
     * @inheritDoc
     */
    protected function configure(): void
    {
        $this->bind(SchemeCollectionInterface::class)->toProvider(ConduitSchemeCollectionProvider::class);
    }
}