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
    * custom id attribute.
    *
    * @var string
    */
    public $id;
    
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($direction = 'rtl', $class = '', $id = 'fj-burger-target')
    {
        $this->direction = $direction;
        $this->class = $class;
        $this->id = $id;
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
