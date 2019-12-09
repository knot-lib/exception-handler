<?php
declare(strict_types=1);

namespace KnotLib\ExceptionHandler\DebugtraceRenderer;

use Throwable;

interface AdditionalDebugTraceRendererInterface
{
    /**
     * Get title of addtional info
     *
     * @return string
     */
    public function getAdditionalInfoTitle() : string;
    
    /**
     * Render addtional info about exception
     *
     * @param Throwable $e
     * @param string &$output
     *
     * @return mixed
     */
    public function renderAdditionalInfo(Throwable $e, string &$output);
    
}