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

/**
 * WriterInterface
 */
interface WriterInterface
{
    /**
     * Write the content.
     *
     * @param resource $resource
     * @return void
     */
    public function write($resource): void;
}