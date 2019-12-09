<?php
declare(strict_types=1);

namespace KnotLib\ExceptionHandler\Handler;

use Throwable;

use Stk2k\File\File;
use KnotLib\ExceptionHandler\ExceptionHandlerInterface;
use KnotLib\ExceptionHandler\DebugtraceRendererInterface;

class FileExceptionHandler implements ExceptionHandlerInterface
{
    /** @var File */
    private $renderer;
    
    /** @var DebugtraceRendererInterface */
    private $file;
    
    /**
     * Charcoal_ConsoleExceptionHandler constructor.
     *
     * @param File $file
     * @param DebugtraceRendererInterface $renderer
     */
    public function __construct(File $file, DebugtraceRendererInterface $renderer)
    {
        $this->file = $file;
        $this->renderer = $renderer;
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
        try{
            // Render exception
            $output = $this->renderer->output($e);
    
            // make directory
            $dir = $this->file->getParent();
    
            if (!$dir->exists()){
                $dir->makeDirectory();
            }
    
            // output
            $this->file->putContents($output);
        }
        catch(Throwable $e){
            exit($e->getMessage());
        }
    
        return true;
    }

}

