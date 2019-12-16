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
     *
     * @return boolean
     */
    public function handleException(Throwable $e);
}

