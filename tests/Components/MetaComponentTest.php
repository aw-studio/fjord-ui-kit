<?php

namespace Tests\Support;

use Tests\TestCase;

class MetaComponentTest extends TestCase
{
    /** @test */
    public function test_meta_component()
    {
        $blade = $this->blade('<x-lit-meta-tags />');
        $blade->assertHas('title');
        $blade->assertHas('meta[name="title"]');
        $blade->assertHas('meta[name="description"]');
        $blade->assertHas('meta[name="keywords"]');
    }

    /** @test */
    public function test_meta_component_with_title()
    {
        $blade = $this->blade('<x-lit-meta-tags title="dummy-title"/>');
        $blade->assertHas('title')->withContent('dummy-title');
    }

    /** @test */
    public function test_meta_component_with_meta_title()
    {
        $blade = $this->blade('<x-lit-meta-tags title="dummy-title"/>');
        $blade->assertHas('meta[name="title"]')->withAttribute('content')->thatIs('dummy-title');
    }

    /** @test */
    public function test_meta_component_with_meta_description()
    {
        $blade = $this->blade('<x-lit-meta-tags description="dummy-description"/>');
        $blade->assertHas('meta[name="description"]')->withAttribute('content')->thatIs('dummy-description');
    }

    /** @test */
    public function test_meta_component_with_meta_keywords()
    {
        $blade = $this->blade('<x-lit-meta-tags keywords="keyword1,keyword2"/>');
        $blade->assertHas('meta[name="keywords"]')->withAttribute('content')->thatIs('keyword1,keyword2');
    }
}
