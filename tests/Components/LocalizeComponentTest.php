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
    public function test_localize_component_has_active_class()
    {
        $blade = $this->blade('<x-fj-localize />');
        $blade->assertHasOne('a.locale-active');
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

    /** @test */
    public function test_localize_component_with_wrapper_tag()
    {
        $blade = $this->blade('<x-fj-localize wrapper="li" />');
        $blade->assertHas('li.locale-en')->withChild('a')->withContent('EN');
        $blade->assertHas('li.locale-de')->withChild('a')->withContent('DE');
    }

    /** @test */
    public function test_localize_component_with_wrapper_tag_sets_classes_to_wrapper()
    {
        $blade = $this->blade('<x-fj-localize wrapper="li" />');
        $blade->assertHas('li.locale-en')->doesntHaveChild('a.locale');
        $blade->assertHas('li.locale-de')->doesntHaveChild('a.locale');
    }

    /** @test */
    public function test_localize_component_with_active_class()
    {
        $this->app->setLocale('en');

        $blade = $this->blade('<x-fj-localize activeClass="is-active" />');
        $blade->assertHasOne('a.is-active');
    }

    /** @test */
    public function test_localize_component_with_wrapper_tag_sets_active_class_to_wrapper()
    {
        $blade = $this->blade('<x-fj-localize wrapper="li" activeClass="is-active" />');
        $blade->assertHasOne('li.is-active');
        $blade->assertDoesntHave('a.is-active');
    }
}
