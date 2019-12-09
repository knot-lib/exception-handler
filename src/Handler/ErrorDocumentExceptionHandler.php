<?php
declare(strict_types=1);

namespace KnotLib\ExceptionHandler\Handler;

use Throwable;

use KnotLib\ExceptionHandler\ExceptionHandlerInterface;
use KnotLib\ExceptionHandler\HttpErrorDocumentProviderInterface;
use KnotLib\Exception\Runtime\HttpStatusException;

class ErrorDocumentExceptionHandler implements ExceptionHandlerInterface
{
    /** @var HttpErrorDocumentProviderInterface */
    private $provider;
    
    /**
     * HttpErrorDocumentExceptionHandler constructor.
     *
     * @param HttpErrorDocumentProviderInterface $provider
     */
    public function __construct(HttpErrorDocumentProviderInterface $provider)
    {
        $this->provider = $provider;
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
        if ($e instanceof HttpStatusException)
        {
            // Show HTTP error document
            $html = $this->provider->getErrorDocument($e->getStatusCode());
            
            // output html
            echo $html;

            return true;
        }

        return false;
    }

}

