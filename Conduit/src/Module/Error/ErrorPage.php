<?php
declare(strict_types=1);

namespace Acme\Conduit\Module\Error;

use Acme\Conduit\Module\ConduitAuth\Exceptions\ForbiddenException;
use Acme\Conduit\Module\ConduitAuth\Exceptions\UnauthorizedException;
use BEAR\Package\Provide\Error\LogRef;
use BEAR\Package\Provide\Error\Status;
use BEAR\Resource\Exception\JsonSchemaException;
use BEAR\Resource\ResourceObject;
use BEAR\Sunday\Extension\Router\RouterMatch;
use Exception;
use function get_class;
use Koriym\HttpConstants\StatusCode;

final class ErrorPage extends ResourceObject
{
    private const VALIDATION_ERROR_CODE = 422;

    public function __construct(Exception $e, RouterMatch $request)
    {
        $status = new Status($e);
        $this->code = $status->code;
        $this->headers = $this->getHeader();
        $this->body = $this->getResponseBody($e, $request, $status);
    }

    public function toString()
    {
        $this->view = json_encode($this->body, JSON_THROW_ON_ERROR | JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES,
                512) . PHP_EOL;

        return $this->view;
    }

    private function getHeader(): array
    {
        return ['content-type' => 'application/json'];
    }

    private function getResponseBody(Exception $e, RouterMatch $request, Status $status): array
    {

        if ($e instanceof JsonSchemaException) {
            $this->code = self::VALIDATION_ERROR_CODE;
            return ParseJsonSchemaMsg::parse($e->getMessage());
        }
        if ($e instanceof UnauthorizedException) {
            $this->code = StatusCode::UNAUTHORIZED;
            return [];
        }
        if ($e instanceof ForbiddenException) {
            $this->code = StatusCode::FORBIDDEN;
            return [];
        }
        if ($e instanceof ValidationErrorException) {
            $this->code = self::VALIDATION_ERROR_CODE;
            return $e->toArray();
        }

        return [
            'message' => $status->text,
            'logref' => (string)new LogRef($e),
            'request' => (string)$request,
            'exceptions' => sprintf('%s(%s)', get_class($e), $e->getMessage()),
            'file' => sprintf('%s(%s)', $e->getFile(), $e->getLine())
        ];
    }
}