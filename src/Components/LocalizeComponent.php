<?php

namespace Fjord\Ui\Components;

use Illuminate\Support\Facades\Request;
use Illuminate\View\Component;

class LocalizeComponent extends Component
{
    /**
     * Parameters for the current route.
     *
     * @var array
     */
    protected $parameters = [];

    protected $route;

    public $routes = [];

    /**
     * Create a new component instance.
     *
     * @param  array $parameters
     * @return void
     */
    public function __construct(array $parameters = [])
    {
        $this->parameters = $parameters;

        $this->route = Request::route();

        $this->setRoutes();
    }

    protected function setRoutes()
    {
        if (! $this->route->getName()) {
        }

        foreach (config('translatable.locales') as $locale) {
            //$name = $this->getQualifiedRouteName($locale);
            $this->routes[$locale] = $this->route->translate($locale);

            //dd($this->route);
        }
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('fjord-ui::localize');
    }
}
