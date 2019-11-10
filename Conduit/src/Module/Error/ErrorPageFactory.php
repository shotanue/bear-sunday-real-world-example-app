<?php
declare(strict_types=1);

namespace Acme\Conduit\Module\Error;

use BEAR\Package\Provide\Error\ErrorPageFactoryInterface;
use BEAR\Resource\ResourceObject;
use BEAR\Sunday\Extension\Router\RouterMatch;
use Exception;

final class ErrorPageFactory implements ErrorPageFactoryInterface
{

    /**
     * @param Exception $e
     * @param RouterMatch $request
     * @return ResourceObject
     */
    public function newInstance(Exception $e, RouterMatch $request): ResourceObject
    {
        return new ErrorPage($e, $request);
    }
}