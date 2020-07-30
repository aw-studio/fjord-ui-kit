<?php

namespace Fjord\Ui;

use Fjord\Ui\Localize\LocalizeServiceProvider;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class FjordUiServiceProvider extends ServiceProvider
{
    /**
     * Blade x components.
     *
     * @var array
     */
    protected $components = [
        'fj-image'      => Components\ImageComponent::class,
        'fj-burger'     => Components\BurgerComponent::class,
        'fj-off-canvas' => Components\OffCanvasComponent::class,
        'fj-nav-list'   => Components\NavListComponent::class,
        'fj-meta-tags'  => Components\MetaTagsComponent::class,
        'fj-localize'   => Components\LocalizeComponent::class,
    ];

    /**
     * Register application services.
     *
     * @return void
     */
    public function register()
    {
        $this->loadViewsFrom(__DIR__.'/../views', 'fjord-ui');

        $this->registerBladeComponents();

        $this->registerPublishes();

        $this->app->register(LocalizeServiceProvider::class);
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
     * Register publishes.
     *
     * @return void
     */
    protected function registerPublishes()
    {
        $this->publishes([
            __DIR__.'/../views' => resource_path('views/vendor/fjord-ui'),
        ], 'views');
    }
}
