<?php

/**
 * TOBENTO
 *
 * @copyright	Tobias Strub, TOBENTO
 * @license     MIT License, see LICENSE file distributed with this source code.
 * @author      Tobias Strub
 * @link        https://www.tobento.ch
 */

declare(strict_types=1);

namespace Tobento\Service\FileCreator\Test;

use PHPUnit\Framework\TestCase;
use Tobento\Service\FileCreator\FileCreator;
use Tobento\Service\FileCreator\FileCreatorException;
use Tobento\Service\Filesystem\Dir;
use Tobento\Service\Filesystem\File;

/**
 * FileCreator tests
 */
class FileCreatorTest extends TestCase
{
    public function testCreateMethodWithContent()
    {
        (new FileCreator())
            ->content('Lorem ipsum')
            ->create(__DIR__.'/files/filename.txt', FileCreator::CONTENT_NEW);
        
		$this->assertSame(
            'Lorem ipsum',
            (new File(__DIR__.'/files/filename.txt'))->getContent()
        );
        
        (new Dir())->delete(__DIR__.'/files/');
	}
    
    public function testCreateMethodWithNewlines()
    {
        (new FileCreator())
            ->content('Lorem ipsum')
            ->newline(num: 2)
            ->content('Lorem ipsum')
            ->create(__DIR__.'/files/filename.txt', FileCreator::CONTENT_NEW);
        
		$this->assertSame(
            'Lorem ipsum'.PHP_EOL.PHP_EOL.'Lorem ipsum',
            (new File(__DIR__.'/files/filename.txt'))->getContent()
        );
        
        (new Dir())->delete(__DIR__.'/files/');
	}
    
    public function testCreateMethodWithContentAndNewline()
    {
        (new FileCreator())
            ->content('Lorem ipsum')
            ->newline()
            ->content('Lorem ipsum')
            ->create(__DIR__.'/files/filename.txt', FileCreator::CONTENT_NEW);
        
		$this->assertSame(
            'Lorem ipsum'.PHP_EOL.'Lorem ipsum',
            (new File(__DIR__.'/files/filename.txt'))->getContent()
        );
        
        (new Dir())->delete(__DIR__.'/files/');
	}
    
    public function testCreateMethodWithoutContent()
    {
        (new FileCreator())
            ->create(__DIR__.'/files/filename.txt', FileCreator::CONTENT_NEW);
        
		$this->assertSame(
            '',
            (new File(__DIR__.'/files/filename.txt'))->getContent()
        );
        
        (new Dir())->delete(__DIR__.'/files/');
	}    

    public function testCreateMethodWithNoOverwriteThrowsFileCreatorExceptionIfFileExist()
    {
        $this->expectException(FileCreatorException::class);
        
        (new FileCreator())
            ->create(__DIR__.'/files/filename.txt', FileCreator::CONTENT_NEW);
        
        (new FileCreator())
            ->create(__DIR__.'/files/filename.txt', FileCreator::NO_OVERWRITE);
        
        (new Dir())->delete(__DIR__.'/files/');
	}
 
    public function testCreateMethodWithContentNew()
    {        
        (new FileCreator())
            ->content('Lorem ipsum')
            ->create(__DIR__.'/files/filename.txt', FileCreator::CONTENT_NEW);
        
        (new FileCreator())
            ->content('Lorem ipsum')
            ->create(__DIR__.'/files/filename.txt', FileCreator::CONTENT_NEW);
        
		$this->assertSame(
            'Lorem ipsum',
            (new File(__DIR__.'/files/filename.txt'))->getContent()
        );
        
        (new Dir())->delete(__DIR__.'/files/');
	} 
    
    public function testCreateMethodWithContentAppend()
    {        
        (new FileCreator())
            ->content('Lorem ipsum')
            ->create(__DIR__.'/files/filename-foo.txt');
        
        (new FileCreator())
            ->content('Lorem ipsum')
            ->create(__DIR__.'/files/filename-foo.txt', FileCreator::CONTENT_APPEND);
        
		$this->assertSame(
            'Lorem ipsumLorem ipsum',
            (new File(__DIR__.'/files/filename-foo.txt'))->getContent()
        );
        
        (new Dir())->delete(__DIR__.'/files/');
	}   
}