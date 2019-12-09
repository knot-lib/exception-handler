<?php
declare(strict_types=1);

namespace KnotLib\ExceptionHandler\Exception;

use KnotLib\Exception\KnotPhpExceptionInterface;
use KnotLib\Exception\Runtime\RuntimeExceptionInterface;

interface ExceptionHandlerExceptionInterface extends KnotPhpExceptionInterface, RuntimeExceptionInterface
{
}


