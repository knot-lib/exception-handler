<?php
declare(strict_types=1);

namespace KnotLib\ExceptionHandler\DebugtraceRenderer;

use Throwable;

use Stk2k\Util\Util;
use KnotLib\ExceptionHandler\DebugtraceRendererInterface;
use KnotLib\Exception\CalgamoException;

class LogDebugtraceRenderer implements DebugtraceRendererInterface
{
    const LOG_EOL        = "\n";

    /** @var AdditionalDebugTraceRendererInterface */
    private $additional;
    
    /**
     * LogDebugtraceRenderer constructor.
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
     * @param Throwable $e  exception to render
     */
    public function render( Throwable $e )
    {
        echo $this->output( $e );
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

        $out .= self::LOG_EOL;
        $out .= "* Exception Stack *" . self::LOG_EOL;
        $out .= "-------------------------------------------------------------" . self::LOG_EOL;

        $no = 1;
        $backtrace = NULL;
        while( $e )
        {
            if (!$backtrace && $e instanceof CalgamoException){
                $backtrace = $e->getBackTraceList();
            }
            
            // get exception info
            $clazz = get_class($e);
            $file = $e->getFile();
            $line = $e->getLine();
            $message = $e->getMessage();

            // print exception info
            $out .= "[$no]$clazz" . self::LOG_EOL;
            $out .= "   $file($line)" . self::LOG_EOL;
            $out .= "   $message" . self::LOG_EOL;

            // move to previous exception
            $e = method_exists( $e, 'getPrevious' ) ? $e->getPrevious() : NULL;
            $no ++;
            if ( $e ){
                $out .= self::LOG_EOL;
            }
        }

        if ( $backtrace === NULL || !is_array($backtrace) ){
            $backtrace = debug_backtrace();
        }

        $out .= self::LOG_EOL;
        $out .= "* Call Stack *" . self::LOG_EOL;
        $out .= "-------------------------------------------------------------" . self::LOG_EOL;

        // print backtrace
        $call_no = 0;
        foreach( $backtrace as $element ){
            $klass = isset($element['class']) ? $element['class'] : '';
            $func  = isset($element['function']) ? $element['function'] : '';
            $type  = isset($element['type']) ? $element['type'] : '';
            $args  = isset($element['args']) ? $element['args'] : array();
            $file  = isset($element['file']) ? $element['file'] : '';
            $line  = isset($element['line']) ? $element['line'] : '';

            $args_disp = '';
            foreach( $args as $arg ){
                if ( strlen($args_disp) > 0 ){
                    $args_disp .= ',';
                }
                $args_disp .= Util::toString($arg);
            }

            if ( $call_no > 0 ){
                $out .= self::LOG_EOL;
            }
            $out .= "[$call_no]{$klass}{$type}{$func}($args_disp)" . self::LOG_EOL;
            $out .= "   {$file}($line)" . self::LOG_EOL;

            $call_no ++;
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

