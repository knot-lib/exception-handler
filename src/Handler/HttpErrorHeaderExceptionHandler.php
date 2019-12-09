<?php
declare(strict_types=1);

namespace KnotLib\ExceptionHandler\Handler;

use Throwable;

use KnotLib\ExceptionHandler\ExceptionHandlerInterface;
use KnotLib\Exception\Runtime\HttpStatusException;

class HttpErrorHeaderExceptionHandler implements ExceptionHandlerInterface
{
    /**
     * handle an exception
     *
     * @param Throwable $e     exception to handle
     *
     * @return boolean
     */
    public function handleException(Throwable $e) : bool
    {
        if ( $e instanceof HttpStatusException )
        {
            static $error_messages = [
                // 10X  Information
                // 20X  Normaly Processed
                '200' => 'OK',
    
                // 30X  Moved Content
                '300' => 'Multiple Choices',
                '301' => 'Moved Permanently',
                '302' => 'Moved Temporarily',
                '303' => 'See Other',
                '304' => 'Not Modified',
                '305' => 'Use Proxy',
                '307' => 'Temporary Redirect',
    
                // 40X Failure
                '401' => 'Unauthorized',
                '402' => 'Payment Required',
                '403' => 'Forbidden',
                '404' => 'Not Found',
                '405' => 'Method Not Allowed',
                '406' => 'Not Acceptable',
                '407' => 'Proxy Authentication Required',
                '408' => 'Request Time-out',
                '409' => 'Conflict',
                '410' => 'Gone',
                '411' => 'Length Required',
                '412' => 'Precondition Failed',
                '413' => 'Request Entity Too Large',
                '414' => 'Request-URI Too Large',
                '415' => 'Unsupported Media Type',
                '416' => 'Requested range not satisfiable',
                '417' => 'Expectation Failed',
    
                // 50 Server Error
                '500' => 'Internal Server Error',
                '501' => 'Not Implemented',
                '502' => 'Bad Gateway',
                '503' => 'Service Unavailable',
                '504' => 'Gateway Time-out',
                '505' => 'HTTP Version not supported',
            ];

            $status = $e->getStatusCode();
            $header_msg = $error_messages[$status] ?? '';

            header( "HTTP/1.0 {$status} {$header_msg}", true, $status );
            
            return true;
        }

        return false;
    }

}

