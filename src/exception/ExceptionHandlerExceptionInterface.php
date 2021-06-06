<?php
declare(strict_types=1);

namespace knotlib\exceptionhandler\exception;

use knotlib\exception\KnotPhpExceptionInterface;
use knotlib\exception\runtime\RuntimeExceptionInterface;

interface ExceptionHandlerExceptionInterface extends KnotPhpExceptionInterface, RuntimeExceptionInterface
{
}


