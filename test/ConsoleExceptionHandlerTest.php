<?php
declare(strict_types=1);

namespace KnotLib\ExceptionHandler\Test;

use PHPUnit\Framework\TestCase;
use KnotLib\Exception\Runtime\HttpStatusException;
use KnotLib\ExceptionHandler\DebugtraceRenderer\ConsoleDebugtraceRenderer;
use KnotLib\ExceptionHandler\Handler\ConsoleExceptionHandler;

class ConsoleExceptionHandlerTest extends TestCase
{
    public function testHandleException()
    {
        $handler = new ConsoleExceptionHandler(new ConsoleDebugtraceRenderer());
    
        ob_start();
        $handler->handleException(new HttpStatusException(404));
        $output = ob_get_clean();
    
        $this->assertEquals('=============================================================', substr($output,0,61));
        $this->assertNotEquals(false, strpos($output,'HTTP status error: status=[404]'));
    }
}