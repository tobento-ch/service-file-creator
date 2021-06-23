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

namespace Tobento\Service\FileCreator\Writer;

use Tobento\Service\FileCreator\WriterInterface;

/**
 * Csv writer
 */
class Csv implements WriterInterface
{    
    /**
     * Create a new Csv Writer
     *
     * @param array $items
     * @param string $delimiter
     * @param string $enclosure
     * @param string $escapeChar
     */
    public function __construct(
        protected array $items,
        protected string $delimiter = ',',
        protected string $enclosure = '"',
        protected string $escapeChar = '\\'
    ) {}
    
    /**
     * Write the content.
     *
     * @param resource $resource
     * @return void
     */
    public function write($resource): void
    {
        if (empty($this->items))
        {
            return;
        }
        
        //add BOM to fix UTF-8 in Excel
        fputs($resource, (chr(0xEF).chr(0xBB).chr(0xBF)));
        
        foreach($this->items as $item)
        {
            if ($verifiedItem = $this->verify($item))
            {
                fputcsv($resource, $verifiedItem, $this->delimiter, $this->enclosure, $this->escapeChar);
            }
        }
    }

    /**
     * Verifies the items
     *
     * @param mixed $item
     * @return null|array Null on failure, otherwise the verified item
     */
    protected function verify(mixed $item): ?array
    {
        if (!is_array($item))
        {
            return null;
        }
        
        return $item;
    }    
}