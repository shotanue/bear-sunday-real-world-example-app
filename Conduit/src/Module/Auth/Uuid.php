<?php
declare(strict_types=1);

namespace Acme\Conduit\Module\Auth;

final class Uuid
{
    /**
     * @var string
     */
    private $uuid;

    public function __construct(string $uuid)
    {
        $this->uuid = $uuid;
    }

    public function __toString()
    {
        return $this->uuid;
    }
}