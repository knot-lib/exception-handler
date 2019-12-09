<?php
declare(strict_types=1);

namespace KnotLib\ExceptionHandler;

use Throwable;

class ExceptionHandlerManager
{
    /** @var  ExceptionHandlerInterface[] */
    private $handlers = [];

    /**
     *  Constructor
     *
     */
    public function __construct()
    {
    }

    /**
     * add exception handler
     *
     * @param ExceptionHandlerInterface $handler       renderer to add
     *
     * @return ExceptionHandlerManager
     */
    public function add( ExceptionHandlerInterface $handler ) : ExceptionHandlerManager
    {
        $this->handlers[] = $handler;
        return $this;
    }

    /**
     * execute exception handlers
     *
     * @param Throwable $e     exception to handle
     *
     * @return boolean        TRUE means the exception is handled, otherwise FALSE
     */
    public function handleException($e)
    {
        foreach( $this->handlers as $handler ){
            $ret = $handler->handleException( $e );
            if ( $ret ){
                return true;
            }
        }

        return false;
    }
}
