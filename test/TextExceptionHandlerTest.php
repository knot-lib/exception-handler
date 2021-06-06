<?php
declare(strict_types=1);

namespace knotlib\exceptionhandler\test;

use PHPUnit\Framework\TestCase;
use knotlib\exception\runtime\HttpStatusException;
use knotlib\exceptionhandler\text\TextDebugtraceRenderer;
use knotlib\exceptionhandler\text\TextExceptionHandler;

class TextExceptionHandlerTest extends TestCase
{
    public function testHandleException()
    {
        $handler = new TextExceptionHandler(new TextDebugtraceRenderer());
    
        ob_start();
        $handler->handleException(new HttpStatusException(404));
        $output = ob_get_clean();

        $output = explode(PHP_EOL, $output);

        $this->assertEquals('=============================================================', $output[0] ?? null);
        $this->assertEquals('Exception stack trace', $output[1] ?? null);
        $this->assertEquals('=============================================================', $output[2] ?? null);
        $this->assertEquals('', $output[3] ?? null);
        $this->assertEquals('* Exception Stack *', $output[4] ?? null);
        $this->assertEquals('-------------------------------------------------------------', $output[5] ?? null);
        $this->assertEquals('[1]knotlib\exception\runtime\HttpStatusException', $output[6] ?? null);
        $this->assertEquals('   HTTP status error: status=[404]', $output[8] ?? null);
    }
}