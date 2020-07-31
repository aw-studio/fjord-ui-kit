<?php

namespace Tests\Support;

use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Route;
use Tests\TestCase;

class LocalizeComponentTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();

        $this->app['config']->set('translatable.locales', ['de', 'en']);

        $route = Route::trans('home', fn () => null)->name('home')->getRoutes()->first();
        $this->setUnaccessibleProperty($route, 'parameters', ['slug' => 'hello']);
        Request::setRouteResolver(fn () => $route);
    }

    /** @test */
    public function test_localize_component()
    {
        $blade = $this->blade('<x-fj-localize />');
        $blade->assertHas('a.locale-en')->withContent('EN');
        $blade->assertHas('a.locale-de')->withContent('DE');
    }

    /** @test */
    public function test_localize_component_with_slots()
    {
        $blade = $this->blade(<<<'BLADE'
        <x-fj-localize>
            <x-slot name="en">
                English
            </x-slot>
            <x-slot name="de">
                Deutsch
            </x-slot>
        </x-fj-localize>
        BLADE);
        $blade->assertHas('a.locale-en')->withContent('English');
        $blade->assertHas('a.locale-de')->withContent('Deutsch');
    }

    /** @test */
    public function test_localize_component_with_selected_locales()
    {
        $blade = $this->blade('<x-fj-localize :locales="[\'en\']"/>');
        $blade->assertHas('a.locale-en')->withContent('EN');
        $blade->assertDoesntHave('a.locale-de');
    }
}
