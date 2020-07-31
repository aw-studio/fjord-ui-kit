<?php

namespace Fjord\Ui\Components;

use Illuminate\View\Component;

class LocalizeComponent extends Component
{
    /**
     * The available locales.
     *
     * @var array
     */
    public $locales = [];

    /**
     * Create new LocalizeComponent instance.
     *
     * @param  array $locales
     * @return void
     */
    public function __construct(array $locales = null)
    {
        if ($locales === null) {
            $this->locales = config('translatable.locales');
        } else {
            $this->locales = $locales;
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
