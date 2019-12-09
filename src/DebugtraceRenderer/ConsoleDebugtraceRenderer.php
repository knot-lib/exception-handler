<?php
declare(strict_types=1);

namespace KnotLib\ExceptionHandler\DebugtraceRenderer;

use Throwable;

use Stk2k\Util\Util;
use KnotLib\Exception\CalgamoException;
use KnotLib\ExceptionHandler\DebugtraceRendererInterface;

class ConsoleDebugtraceRenderer implements DebugtraceRendererInterface
{
    /** @var AdditionalDebugTraceRendererInterface */
    private $additional;
    
    /**
     * ConsoleDebugtraceRenderer constructor.
     *
     * @param AdditionalDebugTraceRendererInterface|null $additional
     */
    public function __construct(AdditionalDebugTraceRendererInterface $additional = null)
    {
        $this->additional = $additional;
    }
    
    /**
     * Render debug trace
     *
     * @param Throwable $e
     */
    public function render( Throwable $e )
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
    public function output( Throwable $e )
    {
        $out = '';

        $out .= "=============================================================" . PHP_EOL;
        $out .= "Exception stack trace " . PHP_EOL;
        $out .= "=============================================================" . PHP_EOL;

        $out .= PHP_EOL;
        $out .= "* Defined Constants *" . PHP_EOL;
        $out .= "-------------------------------------------------------------" . PHP_EOL;
        $declared_constants = Util::getUserDefinedConstants();
        foreach( $declared_constants as $key => $value ){
            $out .= "[$key] $value" . PHP_EOL;
        }
        $out .= "-------------------------------------------------------------" . PHP_EOL;
    
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
        if ( $first_exception instanceof CalgamoException ){
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
        
        // additional debugtrace
        if ($this->additional)
        {
            $title = $this->additional->getAdditionalInfoTitle();
            
            $out .= PHP_EOL;
            $out .= "* {$title} *" . PHP_EOL;
            $out .= "-------------------------------------------------------------" . PHP_EOL;
            
            $this->additional->renderAdditionalInfo( $e, $out );
        }
    
        return $out;
    }

}

