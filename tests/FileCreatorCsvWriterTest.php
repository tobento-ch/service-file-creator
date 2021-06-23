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
use Tobento\Service\FileCreator\Writer\Csv;
use Tobento\Service\Filesystem\Dir;
use Tobento\Service\Filesystem\File;

/**
 * FileCreatorCsvWriterTest tests
 */
class FileCreatorCsvWriterTest extends TestCase
{
    public function testCsvWriter()
    {
        $items = [
            ['id' => 1, 'title' => 'cars'],
            ['id' => 2, 'title' => 'plants'],
        ];

        (new FileCreator())
            ->writer(new Csv($items))
            ->create(__DIR__.'/files/filename.csv', FileCreator::CONTENT_NEW);

		$this->assertTrue(
            (new File(__DIR__.'/files/filename.csv'))->isFile()
        );
        
        (new Dir())->delete(__DIR__.'/files/');
	}
}