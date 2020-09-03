<?php

namespace Tests\Support;

use Tests\TestCase;

class BurgerComponentTest extends TestCase
{
    /** @test */
    public function test_burger_component()
    {
        $blade = $this->blade('<x-lit-burger />');
        $blade->assertHas('button.lit-burger')->withChildren(3, 'span');
    }

    /** @test */
    public function test_burger_component_adds_class()
    {
        $blade = $this->blade('<x-lit-burger class="dummy-class"/>');
        $blade->assertHasOne('button.dummy-class');
    }
}
