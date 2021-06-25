<?php

namespace Litstack\Bladesmith;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Litstack\Bladesmith\Localize\LocalizeServiceProvider;

class BladesmithServiceProvider extends ServiceProvider
{
    /**
     * Blade x components.
     *
     * @var array
     */
    protected $components = [
        'lit-image'      => Components\ImageComponent::class,
        'lit-burger'     => Components\BurgerComponent::class,
        'lit-off-canvas' => Components\OffCanvasComponent::class,
        'lit-nav-list'   => Components\NavListComponent::class,
        'lit-meta-tags'  => Components\MetaTagsComponent::class,
        'lit-localize'   => Components\LocalizeComponent::class,
    ];

    /**
     * The macros to be registered.
     *
     * @var array
     */
    protected $macros = [
        Macros\CrudNavMacro::class,
    ];

    /**
     * Register application services.
     *
     * @return void
     */
    public function register()
    {
        $this->loadViewsFrom(__DIR__.'/../views', 'bladesmith');

        $this->registerBladeComponents();

        $this->registerBladeIfs();

        $this->registerPublishes();

        $this->app->register(LocalizeServiceProvider::class);

        $this->registerMacros();
    }

    /**
     * Register macros.
     *
     * @return void
     */
    public function registerMacros()
    {
        foreach ($this->macros as $macro) {
            (new $macro)->register();
        }
    }

    /**
     * Register blade components.
     *
     * @return void
     */
    protected function registerBladeComponents()
    {
        foreach ($this->components as $name => $class) {
            Blade::component($name, $class);
        }
    }

    /**
     * Register blade ifs.
     *
     * @return void
     */
    protected function registerBladeIfs()
    {
        // Credits: https://stackoverflow.com/questions/677419/how-to-detect-search-engine-bots-with-php
        Blade::if('bot', function () {
            return isset($_SERVER['HTTP_USER_AGENT'])
                && preg_match('/bot|crawl|slurp|spider|mediapartners/i', $_SERVER['HTTP_USER_AGENT']);
        });

        Blade::if('hasslot', function ($slot) {
            return strlen(trim(preg_replace('/\s\s+/', ' ', $slot))) > 0;
        });
    }

    /**
     * Register publishes.
     *
     * @return void
     */
    protected function registerPublishes()
    {
        $this->publishes([
            __DIR__.'/../views' => resource_path('views/vendor/bladesmith'),
        ], 'views');
    }
}
