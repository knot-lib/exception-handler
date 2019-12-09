<?php
declare(strict_types=1);

namespace KnotLib\ExceptionHandler;

interface HttpErrorDocumentProviderInterface
{
    /**
     * Provide error document related by http status
     *
     * @param int $status
     *
     * @return string
     */
    public function getErrorDocument(int $status) : string;
}