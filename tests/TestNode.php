<?php

namespace Tests;

use PHPHtmlParser\Dom;
use PHPHtmlParser\Dom\Node\HtmlNode;
use PHPUnit\Framework\Assert as PHPUnit;

class TestNode
{
    /**
     * Dom instance.
     *
     * @var HtmlNode
     */
    protected $node;

    /**
     * Create new TestDom instance..
     *
     * @param  string $html
     * @return void
     */
    public function __construct(HtmlNode $node)
    {
        $this->node = $node;
    }

    /**
     * Get node instance.
     *
     * @return DoHtmlNodem
     */
    public function getNode()
    {
        return $this->node;
    }

    /**
     * Assert node doesn't have child node with the given selector.
     *
     * @param  string   $selector
     * @return TestNode
     */
    public function doesntHaveChild($selector)
    {
        PHPUnit::assertNull(
            $this->node->find($selector, 0),
            "Failed asserting that Html doesn't have child node with selector [{$selector}]."
        );

        return $this;
    }

    /**
     * Assert node has child node with the given selector.
     *
     * @param  string   $selector
     * @return TestNode
     */
    public function withChild($selector)
    {
        PHPUnit::assertNotNull(
            $node = $this->node->find($selector, 0),
            "Failed asserting that Html has element with selector [{$selector}]."
        );

        return new self($node);
    }

    /**
     * Assert node has child node with the given selector.
     *
     * @param  int    $count
     * @param  string $selector
     * @return $this
     */
    public function withChildren($count, $selector)
    {
        PHPUnit::assertCount(
            $count, $this->node->find($selector),
            "Failed asserting that node has nth children with selector [{$selector}]."
        );

        return $this;
    }

    public function withAttribute($attribute)
    {
        PHPUnit::assertNotNull(
            $attribute = $this->node->getAttribute($attribute),
            "Failed asserting that node has attribute name [{$attribute}]."
        );

        return new TestAttribute($attribute);
    }

    /**
     * Assert node contains html.
     *
     * @param  string $needle
     * @return $this
     */
    public function withContent($needle)
    {
        PHPUnit::assertEquals(
            trim($needle), trim($this->node->innerHtml()),
            "Failed asserting that nodes content is {$needle}."
        );

        return $this;
    }

    /**
     * Assert node contains html.
     *
     * @param  string $needle
     * @return $this
     */
    public function thatContains($needle)
    {
        PHPUnit::assertStringContainsString(
            trim($needle), trim($this->node->innerHtml()),
            "Failed asserting that node contains {$needle}."
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
        return (string) $this->node;
    }
}
