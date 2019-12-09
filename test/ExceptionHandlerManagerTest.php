<?php
declare(strict_types=1);

namespace KnotLib\ExceptionHandler\Test;

use PHPUnit\Framework\TestCase;
use KnotLib\ExceptionHandler\Handler\PrintExceptionHandler;
use KnotLib\ExceptionHandler\DebugtraceRenderer\HtmlDebugtraceRenderer;
use KnotLib\Exception\Runtime\HttpStatusException;
use KnotLib\ExceptionHandler\ExceptionHandlerManager;

class ExceptionHandlerManagerTest extends TestCase
{
    public function testRender()
    {
        $ex_magr = new ExceptionHandlerManager();
        
        $renderer = new HtmlDebugtraceRenderer();
        $handler = new PrintExceptionHandler($renderer);
    
        $ex_magr->add( $handler );
    
    
        ob_start();
        $ex_magr->handleException(new HttpStatusException(404));
        $html = ob_get_clean();
    
        $this->assertEquals('<!DOCTYPE html PUBLIC', substr($html,0,21));
        $this->assertNotEquals(false, strpos($html,'<td class="message"><div class="value">HTTP status error: status=[404]</div></td>'));
    }
}