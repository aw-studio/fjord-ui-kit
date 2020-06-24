<?php

namespace Fjord\Ui;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class FjordUiServiceProvider extends ServiceProvider
{
    protected $components = [
        'fj-image' => Components\ImageComponent::class
    ];

    /**
     * Register application services.
     *
     * @return void
     */
    public function register()
    {
        $this->loadViewsFrom(__DIR__ . '/../views', 'fjord-ui');

        $this->registerBladeComponents();

        $this->registerPublishes();
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
            __DIR__ . '/../views' => resource_path('views/vendor/fjord-ui'),
        ], 'views');
    }
}
