<?php
declare(strict_types=1);

namespace knotlib\exceptionhandler\exception;

use Throwable;

use knotlib\exception\KnotPhpException;

class ExceptionHandlerException extends KnotPhpException implements ExceptionHandlerExceptionInterface
{
    /**
     * ExceptionHandlerException constructor.
     *
     * @param string $message
     * @param int $code
     * @param Throwable|null $prev
     */
    public function __construct(string $message, int $code = 0, Throwable $prev = null)
    {
        parent::__construct($message, $code, $prev);
    }

}

