<?php

namespace Tests;

use PHPHtmlParser\Dom;
use PHPUnit\Framework\Assert as PHPUnit;

class TestAttribute
{
    /**
     * Dom instance.
     *
     * @var string
     */
    protected $attribute;

    /**
     * Create new TestDom instance..
     *
     * @param  string $html
     * @return void
     */
    public function __construct($attribute)
    {
        $this->attribute = $attribute;
    }

    /**
     * Get node instance.
     *
     * @return string
     */
    public function getAttribute()
    {
        return $this->attribute;
    }

    /**
     * Assert node contains html.
     *
     * @param  string $needle
     * @return $this
     */
    public function thatIs($needle)
    {
        PHPUnit::assertStringContainsString(
            trim($needle), trim($this->attribute),
            "Failed asserting that attribute is {$needle}."
        );

        return $this;
    }

    /**
     * Parse node to html.
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->attribute;
    }
}
