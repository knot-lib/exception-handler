<?php
declare(strict_types=1);

namespace knotlib\exceptionhandler;

use Throwable;

interface ExceptionHandlerInterface
{
    /**
     * handle an exception
     *
     * @param Throwable $e     exception to handle
     */
    public function handleException(Throwable $e) : void;
}

