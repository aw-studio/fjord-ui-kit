<?php

namespace Fjord\Ui\Localize;

use Closure;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Route as RouteFacade;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use LogicException;

class LocalizeServiceProvider extends ServiceProvider
{
    /**
     * Register application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('route.trans', function ($app) {
            return new TransRoute($app['config']['translatable.locales']);
        });

        // Macros
        $this->registerTransMacro();
        $this->registerTranslateMacro();
        $this->registerTranslatorMacro();
        $this->registerGetNameWithoutLocaleMacro();
    }

    /**
     * Register the macro.
     *
     * @return void
     */
    protected function registerTransMacro()
    {
        RouteFacade::macro('trans', function ($route, $controller) {
            return app('route.trans')->trans($route, $controller);
        });
    }

    /**
     * Register the macro.
     *
     * @return void
     */
    protected function registerTranslateMacro()
    {
        Route::macro('translate', function ($locale) {
            if (Request::route()->getName() != $this->getName()) {
                throw new LogicException('You may only translate the current route.');
            }

            if (! $this->translator) {
                return url($this->uri, $this->parameters());
            }

            return call_user_func($this->translator, $locale);
        });
    }

    /**
     * Register the macro.
     *
     * @return void
     */
    protected function registerTranslatorMacro()
    {
        Route::macro('translator', function ($translator) {
            $this->translator = function ($locale) use ($translator) {
                if ($translator instanceof Closure) {
                    $parameters = $translator($locale);
                } else {
                    $parameters = $this->getController()->$translator(
                        $locale,
                        ...array_values(Request::route()->parameters())
                    );
                }

                $name = $this->getNameWithoutLocale();

                return __route($name, $parameters, true, $locale);
            };

            return $this;
        });
    }

    /**
     * Register the macro.
     *
     * @return void
     */
    protected function registerGetNameWithoutLocaleMacro()
    {
        Route::macro('getNameWithoutLocale', function () {
            $name = $this->getName();

            foreach (config('translatable.locales') as $locale) {
                if (Str::startsWith($name, $locale.'.')) {
                    return Str::replaceFirst($locale.'.', '', $name);
                }
            }

            return $name;
        });
    }
}
