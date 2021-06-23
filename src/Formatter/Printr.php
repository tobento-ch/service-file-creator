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

namespace Tobento\Service\FileCreator\Formatter;

use Tobento\Service\FileCreator\FormatterInterface;

/**
 * Print Formatter.
 */
class Printr implements FormatterInterface
{
    /**
     * Formats the content.
     *
     * @param mixed $content Any content.
     * @return string The formatted content.
     */
    public function format(mixed $content): string
    {
        return str_replace("\n", "\r\n", print_r($content, true));
    }
}