<?php
declare(strict_types=1);

namespace KnotLib\ExceptionHandler;

use Throwable;

interface DebugtraceRendererInterface
{
    /**
     * Render debug trace
     *
     * @param Throwable $e  exception to render
     */
    public function render(Throwable $e) : void;
    
    /**
     * Output debug trace
     *
     * @param Throwable $e
     *
     * @return string
     */
    public function output(Throwable $e) : string;
}

