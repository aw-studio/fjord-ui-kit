<?php

namespace Litstack\Bladesmith\Macros;

use Closure;
use Ignite\Crud\CrudShow;

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
            return $this->list($name)->previewTitle('{title}')->form(function ($form) use ($closure) {
                // Title field.
                $form->input('title')->title('Link Text')->translatable(lit()->isAppTranslatable())->width(8);
                
                // External.
                $form->boolean('external')->title('External Link');

                // Route field.
                $form->route('route')->title('Route (intern)')->collection('app')->allowEmpty()->whenNot('external', true);

                // URL field.
                $form->input('url')->title('URL (extern)')->when('external', true);

                // _blank boolean.
                $form->boolean('target_blank');

                // Next we are allowing to append field by passing the form to
                // a closure if given.
                if ($closure instanceof Closure) {
                    $closure($form);
                }
            });
        });
    }
}
