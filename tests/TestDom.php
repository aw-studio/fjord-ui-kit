<?php

namespace Tests;

use PHPHtmlParser\Dom;
use PHPUnit\Framework\Assert as PHPUnit;

class TestDom
{
    /**
     * Raw html.
     *
     * @var string
     */
    protected $html;

    /**
     * Dom instance.
     *
     * @var Dom
     */
    protected $dom;

    /**
     * Create new TestDom instance..
     *
     * @param  string $html
     * @return void
     */
    public function __construct($html)
    {
        $this->html = $html;
        $this->dom = (new Dom)->loadStr($html);
    }

    /**
     * Get raw html.
     *
     * @return string
     */
    public function getHtml()
    {
        return $this->html;
    }

    /**
     * Get dom instance.
     *
     * @return Dom
     */
    public function getDom()
    {
        return $this->dom;
    }

    /**
     * Assert dom has node with the given selector.
     *
     * @param  string $selector
     * @return $this
     */
    public function assertHas($selector)
    {
        PHPUnit::assertGreaterThanOrEqual(
            1, count($this->dom->find($selector)),
            "Failed asserting that Html has element with selector [{$selector}]."
        );

        return $this;
    }

    /**
     * Assert dom has one node with the given selector.
     *
     * @param  string $selector
     * @return $this
     */
    public function assertHasOne($selector)
    {
        PHPUnit::assertCount(
            1, $this->dom->find($selector),
            "Failed asserting that Html has one element with selector [{$selector}]."
        );

        return $this;
    }

    /**
     * Assert dom has two nodes with the given selector.
     *
     * @param  string $selector
     * @return $this
     */
    public function assertHasTwo($selector)
    {
        PHPUnit::assertCount(
            2, $this->dom->find($selector),
            "Failed asserting that Html has two element with selector [{$selector}]."
        );

        return $this;
    }

    /**
     * Assert dom has nth nodes with the given selector.
     *
     * @param  int    $count
     * @param  string $selector
     * @return $this
     */
    public function assertCount($count, $selector)
    {
        $nodes = $this->dom->find($selector);

        PHPUnit::assertCount(
            $count, $nodes,
            'Failed asserting that actual size of nodes '.count($nodes)." with selector [{$selector}] matches size {$count}."
        );

        return $this;
    }
}
