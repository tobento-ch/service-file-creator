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
 * Interface for the file creator formatter.
 */
interface FormatterInterface
{
    /**
     * Formats the content.
     *
     * @param mixed $content Any content.
     * @return string The formatted content.
     */
    public function format(mixed $content): string;
}