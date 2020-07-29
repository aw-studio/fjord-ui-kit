<?php

namespace Fjord\Ui\Components;

use Illuminate\View\Component;

class BurgerComponent extends Component
{
    /**
     * css class for customization.
     *
     * @var string
     */
    public $class;

    /**
     * The target element to toggel a class.
     *
     * @var string
     */
    public $target;

    /**
     * The class name to toggel on the target element.
     *
     * @var string
     */
    public $toggleclass;

    /**
     * Numer of burger bars (2 or 3, default is 2).
     *
     * @var string
     */
    public $bars;

    /**
     * Create a new component instance.
     *
     * @param  string $class
     * @param  string $target
     * @param  string $toggleclass
     * @param  string $bars
     * @return void
     */
    public function __construct($class = '', $target = '#fj-burger-target', $toggleclass = 'fj--visible', $bars = 2)
    {
        $this->class = $class;
        $this->target = $target;
        $this->toggleclass = $toggleclass;
        $this->bars = $bars;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('fjord-ui::burger');
    }
}
