<?php

/**
 * TOBENTO
 *
 * @copyright   Tobias Strub, TOBENTO
 * @license     MIT License, see LICENSE file distributed with this source code.
 * @author      Tobias Strub
 * @link        https://www.tobento.ch
 */

declare(strict_types=1);

namespace Tobento\Service\FileCreator;

use Tobento\Service\Filesystem\File;
use Tobento\Service\Filesystem\Dir;

/**
 * File Creator
 */
class FileCreator
{
    /**
     * @const Handling options.
     */    
    const NO_OVERWRITE = 0; // cannot overwrite existing file.
    const CONTENT_APPEND = 1; // append content if file exists.
    const CONTENT_NEW = 2; // clear file and set content if file exists.
            
    /**
     * @var string The file content.
     */
    protected string $content = '';

    /**
     * @var array Writers
     */
    protected array $writers = [];

    /**
     * @var null|resource The file Handle.
     */
    protected $fileHandle = null;

    /**
     * Create a new FileCreator
     */    
    final public function __construct()
    {
        //
    }
    
    /**
     * Adds content.
     *
     * @param string $content The content.
     * @return static $this
     */    
    public function content(string $content): static
    {
        $this->content .= $content;
        return $this;
    }

    /**
     * Adds a writer.
     *
     * @param WriterInterface $writer
     * @return static $this
     */    
    public function writer(WriterInterface $writer): static
    {
        $this->writers[] = $writer;
        return $this;
    }    

    /**
     * Adds newline.
     *
     * @param int $num The number of new lines.
     * @return FileCreator
     */    
    public function newline(int $num = 1): FileCreator
    {
        for ($i = 1; $i <= $num; $i++) {
            $this->content .= "\r\n";
        }
        
        return $this;
    }
            
    /**
     * Creates the file with the content set.
     *
     * @param string $file The file.
     * @param int $handling The handling see const handling options.     
     * @param int $modeFile The mode such as 0644 for the file.
     * @param int $modeDir The mode such as 0644 for the dir.
     *
     * @throws FileCreatorException
     *
     * @return static Returns a new instance
     */    
    public function create(
        string $file,
        int $handling = self::NO_OVERWRITE,
        int $modeFile = 0644,
        int $modeDir = 0755
    ): static {
        
        $file = new File($file);
        
        if ($file->isFile())
        {
            if ($handling === self::NO_OVERWRITE)
            {
                throw new FileCreatorException('Writing to existing files is disabled');
            }
            
            if (! $file->isWritable())
            {
                throw new FileCreatorException('File "'.$file->getFile().'" is not writable!');
            }
        }
        
        // Check directory for its existence or try to create it.
        $dir = new Dir();
        
        if (! $dir->has($file->getDirname()))
        {
            // create dir.
            if ($dir->create($file->getDirname(), $modeDir, true) === false)
            {
                throw new FileCreatorException('Could not create directory "'.$file->getDirname().'"');
            }
        }

        // Check if directory is writeable.
        if(! $dir->isWritable($file->getDirname()))
        {
            throw new FileCreatorException('Directory "'.$file->getDirname().'" is not writable!');
        }

        // Open the file. If it does not exists, it tries to create it.
        $this->fileHandle = fopen($file->getFile(), 'a');
        
        // Clear file content to 0 bits.
        if ($handling === self::CONTENT_NEW)
        {
            ftruncate($this->fileHandle, 0);
        }

        // Check if file is writeable.
        if (! $file->isWritable())
        {
            throw new FileCreatorException('File "'.$file->getFile().'" is not writable!');
        }
        
        // Handle the writers if any.
        foreach($this->writers as $writer)
        {
            $writer->write($this->fileHandle);    
        }
        
        // Write the content to the file.
        if ($this->content !== '')
        {
            if (fwrite($this->fileHandle, $this->content) === false)
            {
                throw new FileCreatorException('Could not write to file "'.$file->getFile().'"!');
            }
        }

        // file mode.
        chmod($file->getFile(), $modeFile);
                
        return new static();
    }

    /**
     * Close the fileHandle
     */    
    public function __destruct()
    {
        if (is_resource($this->fileHandle))
        {
            fclose($this->fileHandle);
        }
        
        $this->fileHandle = null;
    }
}