<?php

namespace Webmacaj\Nominatim\Formatter;

/**
 * Interface FormatterInterface
 */
interface FormatterInterface
{
    /**
     * Format input data to array. Returns null on failure.
     *
     * @param string $data
     *
     * @return array|null
     */
    public function format(string $data): ?array;
}