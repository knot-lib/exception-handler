<?php
declare(strict_types=1);

namespace KnotLib\ExceptionHandler\Handler;

use Throwable;

use KnotLib\ExceptionHandler\ExceptionHandlerInterface;
use KnotLib\ExceptionHandler\DebugtraceRendererInterface;

class StdErrorExceptionHandler implements ExceptionHandlerInterface
{
    /** @var DebugtraceRendererInterface */
    private $renderer;
    
    /**
     * Charcoal_ConsoleExceptionHandler constructor.
     *
     * @param DebugtraceRendererInterface $renderer
     */
    public function __construct(DebugtraceRendererInterface $renderer)
    {
        $this->renderer = $renderer;
    }
    
    /**
     * execute exception handlers
     *
     * @param Throwable $e     exception to handle
     */
    public function handleException(Throwable $e)
    {
        // Render exception
        $output = $this->renderer->output($e);
    
        // output
        fwrite(STDERR, $output . PHP_EOL);
    }

}

