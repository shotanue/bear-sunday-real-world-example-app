<?php
declare(strict_types=1);

namespace Acme\Conduit\Module\Error;

use BEAR\Resource\Exception\ExceptionInterface;
use InvalidArgumentException;
use Ray\Validation\FailureInterface;
use Throwable;

/**
 * Class ValidationErrorException
 * @package Acme\Conduit\Module\Error
 */
final class ValidationErrorException extends InvalidArgumentException implements ExceptionInterface
{
    /**
     * @var FailureInterface|null
     */
    private $failure;

    /**
     * ValidationErrorException constructor.
     *
     * forbid create instance, but self::create()
     *
     * @param string $message
     * @param int $code
     * @param Throwable|null $previous
     */
    private function __construct($message = '', $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    /**
     * @param FailureInterface $failure
     * @return ValidationErrorException
     */
    public static function create(FailureInterface $failure): ValidationErrorException
    {
        $e = new self();
        $e->setFailure($failure);
        return $e;
    }

    /**
     * expects just self::create() calls this setter method
     * @param FailureInterface $failure
     */
    private function setFailure(FailureInterface $failure)
    {
        $this->failure = $failure;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        $arr = [];
        foreach ($this->failure->getMessages() as $property => $errorMessages) {
            /** @var $errorMessages string[] */
            $arr[$property] = implode('.', $errorMessages);
        }
        return $arr;
    }
}