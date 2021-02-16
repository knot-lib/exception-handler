<?php
declare(strict_types=1);

namespace KnotLib\ExceptionHandler\Test;

use PHPUnit\Framework\TestCase;
use KnotLib\Exception\Runtime\HttpStatusException;
use KnotLib\ExceptionHandler\Text\TextDebugtraceRenderer;

class TextDebugtraceRendererTest extends TestCase
{
    public function testRender()
    {
        $renderer = new TextDebugtraceRenderer();
        
        ob_start();
        $renderer->render(new HttpStatusException(404));
        $output = ob_get_clean();

        $output = explode(PHP_EOL, $output);

        $this->assertEquals('=============================================================', $output[0] ?? null);
        $this->assertEquals('Exception stack trace', $output[1] ?? null);
        $this->assertEquals('=============================================================', $output[2] ?? null);
        $this->assertEquals('', $output[3] ?? null);
        $this->assertEquals('* Exception Stack *', $output[4] ?? null);
        $this->assertEquals('-------------------------------------------------------------', $output[5] ?? null);
        $this->assertEquals('[1]KnotLib\Exception\Runtime\HttpStatusException', $output[6] ?? null);
        $this->assertEquals('   HTTP status error: status=[404]', $output[8] ?? null);
    }
}