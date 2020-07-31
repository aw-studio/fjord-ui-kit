<?php

namespace Fjord\Ui\Macros;

use Closure;
use Fjord\Crud\CrudShow;

class CrudNavMacro
{
    /**
     * Register the macro.
     *
     * @return void
     */
    public function register()
    {
        CrudShow::macro('nav', function ($name, Closure $closure = null) {
            return $this->list('nav')->previewTitle('{title}')->form(function ($form) use ($closure) {
                // Title field.
                $form->input('title')->title('Link Text');

                // Route field.
                $form->route('route')->title('Route')->collection('app');

                // Next we are allowing to append field by passing the form to
                // a closure if given.
                if ($closure instanceof Closure) {
                    $closure($form);
                }
            });
        });
    }
}
