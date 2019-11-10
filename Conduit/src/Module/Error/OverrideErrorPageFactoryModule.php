<?php
declare(strict_types=1);

namespace Acme\Conduit\Module\Error;

use BEAR\Package\Provide\Error\ErrorPageFactoryInterface;
use Ray\Di\AbstractModule;

final class OverrideErrorPageFactoryModule extends AbstractModule
{

    /**
     * Configure binding
     *
     * override error module below
     * @see \BEAR\Package\Provide\Error\VndErrorModule
     */
    protected function configure(): void
    {
        $this->bind(ErrorPageFactoryInterface::class)->to(ErrorPageFactory::class);
    }
}