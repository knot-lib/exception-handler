<?php
declare(strict_types=1);

namespace KnotLib\ExceptionHandler\Handler;

use Throwable;

use KnotLib\ExceptionHandler\ExceptionHandlerInterface;
use KnotLib\ExceptionHandler\DebugtraceRendererInterface;

class ConsoleExceptionHandler implements ExceptionHandlerInterface
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
        // Get output exception
        $output = $this->renderer->output($e);
        
        // output
        echo $output;
    }

}

