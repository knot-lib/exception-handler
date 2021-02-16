<?php
declare(strict_types=1);

namespace KnotLib\ExceptionHandler\Text;

use KnotLib\ExceptionHandler\DebugtraceRendererInterface;
use KnotLib\ExceptionHandler\ExceptionHandlerInterface;
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