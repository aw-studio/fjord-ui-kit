<?php

namespace Fjord\Ui\Components;

use Illuminate\View\Component;

class OffCanvas extends Component
{

    /**
     * Direction from where the off canvas animates in
     *
     * @var string
     */
    public $direction;

    /**
    * Custom css class(es).
    *
    * @var string
    */
    public $class;

    /**
    * Target id for bring to viewport function.
    *
    * @var string
    */
    public $target_id;
    
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($direction = 'rtl', $class = '', $target_id = 'fj-burger-target')
    {
        $this->direction = $direction;
        $this->class = $class;
        $this->target_id = $target_id;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('fjord-ui::off-canvas');
    }
}
