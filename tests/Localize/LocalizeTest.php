<?php

namespace Tests\Localize;

use Fjord\Ui\Localize\TranslatedRoutes;
use Illuminate\Support\Facades\Route;
use Tests\TestCase;

class LocalizeTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();

        $this->app['config']->set('translatable.locales', ['de', 'en']);
    }

    /** @test */
    public function it_creates_a_routes_for_each_locale()
    {
        $this->assertCount(0, Route::getRoutes()->getRoutes());

        Route::trans('home', fn () => null);

        $this->assertCount(2, Route::getRoutes()->getRoutes());
    }

    /** @test */
    public function it_returns_translated_routes()
    {
        $routes = Route::trans('home', fn () => null);

        $this->assertInstanceOf(TranslatedRoutes::class, $routes);
    }

    /** @test */
    public function it_adds_locale_route_prefix()
    {
        Route::trans('home', fn () => null);

        foreach (Route::getRoutes()->getRoutes() as $route) {
            $this->assertContains(explode('/', $route->uri)[0], ['de', 'en']);
        }
    }

    /** @test */
    public function it_prepends_locale_to_name()
    {
        Route::trans('home', fn () => null);

        foreach (Route::getRoutes()->getRoutes() as $route) {
            $this->assertContains(explode('.', $route->getName())[0], ['de', 'en']);
        }
    }
}
