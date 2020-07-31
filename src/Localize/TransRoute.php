<?php

namespace Fjord\Ui\Localize;

use Closure;
use Illuminate\Support\Facades\Route;

class TransRoute
{
    /**
     * Locales.
     *
     * @var array
     */
    protected $locales = [];

    /**
     * Create new TransRoute instance.
     *
     * @param  array $locales
     * @return void
     */
    public function __construct(array $locales = [])
    {
        $this->locales = $locales;
    }

    /**
     * Create translated routes.
     *
     * @param  string $uri
     * @param  string $action
     * @return void
     */
    public function trans($uri, $action)
    {
        if (is_array($action)) {
            $action = implode('@', $action);
        }

        $routes = collect([]);

        foreach ($this->locales as $locale) {
            $routes->push(
                $this->makeTransRouteForLocale($uri, $action, $locale)
            );
        }

        return new TranslatedRoutes($routes);
    }

    /**
     * Make translated route for locale.
     *
     * @param  string                    $uri
     * @param  string|array|Closure      $action
     * @param  string                    $locale
     * @return \Illuminate\Routing\Route
     */
    protected function makeTransRouteForLocale($uri, $action, $locale)
    {
        $uri = $this->compileUri($uri, $locale);

        $route = Route::prefix($locale)
            ->as("{$locale}.")
            ->get($uri, $action)
            ->translator(fn ($locale) => []);

        return $route;
    }

    /**
     * Replaces __(param) with translated values.
     *
     * @param  string $uri
     * @param  string $locale
     * @return string
     */
    protected function compileUri($uri, $locale)
    {
        preg_match_all('/\__\((.*?)\)/si', $uri, $matches);

        foreach ($matches[1] as $parameter) {
            $search = $this->getTranslationParameter($parameter);
            $replace = __(trim($parameter), [], $locale);

            $uri = str_replace($search, $replace, $uri);
        }

        return $uri;
    }

    /**
     * Get route parameter.
     *
     * @param  string $parameter
     * @return string
     */
    protected function getTranslationParameter($parameter)
    {
        return "__({$parameter})";
    }
}