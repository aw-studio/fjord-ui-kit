<?php

namespace Tests;

use PHPUnit\Framework\Assert as PHPUnit;

class TestAttribute
{
    /**
     * Attribute value.
     *
     * @var string
     */
    protected $attribute;

    /**
     * Create new TestAttribute instance.
     *
     * @param  string $attribute
     * @return void
     */
    public function __construct($attribute)
    {
        $this->attribute = $attribute;
    }

    /**
     * Get attribute value.
     *
     * @return string
     */
    public function getAttribute()
    {
        return $this->attribute;
    }

    /**
     * Assert attribute value is.
     *
     * @param  string $needle
     * @return $this
     */
    public function thatIs($needle)
    {
        PHPUnit::assertEquals(
            preg_replace('/\s\s+/', '', $needle), preg_replace('/\s\s+/', '', $this->attribute),
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
