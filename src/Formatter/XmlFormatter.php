<?php

namespace Webmacaj\Nominatim\Formatter;

class XmlFormatter implements FormatterInterface
{
    /** @var \XMLReader */
    protected $_xml;

    /**
     * XmlFormatter constructor.
     */
    public function __construct()
    {
        $this->_xml = new \XMLReader();
    }

    /**
     * {@inheritdoc}
     */
    public function format(string $data): ?array
    {
        // TODO: Implement format() method.
    }
}