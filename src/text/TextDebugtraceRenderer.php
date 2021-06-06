<?php
declare(strict_types=1);

namespace knotlib\exceptionhandler\text;

use Throwable;

use knotlib\exception\KnotPhpException;
use knotlib\exceptionhandler\DebugtraceRendererInterface;

class TextDebugtraceRenderer implements DebugtraceRendererInterface
{
    /**
     * Render debug trace
     *
     * @param Throwable $e
     */
    public function render(Throwable $e) : void
    {
        echo $this->output($e);
    }
    
    /**
     * Output debug trace
     *
     * @param Throwable $e
     *
     * @return string
     */
    public function output(Throwable $e) : string
    {
        $out = '';

        $out .= "=============================================================" . PHP_EOL;
        $out .= "Exception stack trace" . PHP_EOL;
        $out .= "=============================================================" . PHP_EOL;

        $out .= PHP_EOL;
        $out .= "* Exception Stack *" . PHP_EOL;
        $out .= "-------------------------------------------------------------" . PHP_EOL;

        $first_exception = $e;

        $no = 1;
        while( $e )
        {
            // get exception info
            $clazz = get_class($e);
            $file = $e->getFile();
            $line = $e->getLine();
            $message = $e->getMessage();

            // print exception info
            $out .= "[$no]$clazz" . PHP_EOL;
            $out .= "   $file($line)" . PHP_EOL;
            $out .= "   $message" . PHP_EOL;

            // move to previous exception
            $e = method_exists( $e, 'getPrevious' ) ? $e->getPrevious() : NULL;
            $no ++;
            if ( $e ){
                $out .= PHP_EOL;
            }
        }


        // get backtrace
        if ( $first_exception instanceof KnotPhpException ){
            $backtrace = $first_exception->getBackTraceList();

            $out .= PHP_EOL;
            $out .= "* Call Stack *" . PHP_EOL;
            $out .= "-------------------------------------------------------------" . PHP_EOL;

            // print backtrace
            $call_no = 0;
            foreach( $backtrace as $element ){
                $klass = isset($element['class']) ? $element['class'] : '';
                $func  = isset($element['function']) ? $element['function'] : '';
                $type  = isset($element['type']) ? $element['type'] : '';
                $file  = isset($element['file']) ? $element['file'] : '';
                $line  = isset($element['line']) ? $element['line'] : '';

                if ( $call_no > 0 ){
                    $out .= PHP_EOL;
                }
                $out .= "[$call_no]{$klass}{$type}{$func}()" . PHP_EOL;
                $out .= "   {$file}($line)" . PHP_EOL;

                $call_no ++;
            }
        }
    
        return $out;
    }

}

