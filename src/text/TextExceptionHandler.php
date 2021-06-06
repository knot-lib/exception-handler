<?php
declare(strict_types=1);

namespace knotlib\exceptionhandler\text;

use knotlib\exceptionhandler\DebugtraceRendererInterface;
use knotlib\exceptionhandler\ExceptionHandlerInterface;
use Throwable;

class TextExceptionHandler implements ExceptionHandlerInterface
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
     * @param Throwable $e
     */
    public function handleException(Throwable $e) : void
    {
        $this->renderer->render($e);
    }
}