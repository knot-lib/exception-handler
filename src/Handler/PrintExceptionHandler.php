<?php
declare(strict_types=1);

namespace KnotLib\ExceptionHandler\Handler;

use Throwable;

use KnotLib\ExceptionHandler\ExceptionHandlerInterface;
use KnotLib\ExceptionHandler\DebugtraceRendererInterface;

class PrintExceptionHandler implements ExceptionHandlerInterface
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
     *
     * @return boolean        TRUE means the exception is handled, otherwise FALSE
     */
    public function handleException(Throwable $e) : bool
    {
        // Render exception
        echo $this->renderer->output($e);

        return true;
    }

}

