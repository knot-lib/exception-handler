<?php
declare(strict_types=1);

namespace KnotLib\ExceptionHandler;

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

