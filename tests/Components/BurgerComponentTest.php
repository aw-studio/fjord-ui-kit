<?php

namespace Tests\Support;

use Tests\TestCase;

class BurgerComponentTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
    }

    /** @test */
    public function test_burger_component()
    {
        $blade = $this->blade('<x-fj-burger />');
        $blade->assertHasOne('button.fj-burger');
    }

    /** @test */
    public function test_burger_component_adds_class()
    {
        $blade = $this->blade('<x-fj-burger class="dummy-class"/>');
        $blade->assertHasOne('button.dummy-class');
    }

    /** @test */
    public function test_burger_component_contains_three_spans()
    {
        $blade = $this->blade('<x-fj-burger />');
        $blade->assertCount(3, 'button.fj-burger span');
    }
}
