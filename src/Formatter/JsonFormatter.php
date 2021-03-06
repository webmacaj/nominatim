<?php

namespace Webmacaj\Nominatim\Formatter;

class JsonFormatter implements FormatterInterface
{
    /**
     * {@inheritdoc}
     */
    public function format(string $data): ?array
    {
        return \json_decode($data, true);
    }
}