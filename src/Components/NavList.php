<?php

namespace Fjord\Ui\Components;

use Illuminate\View\Component;

class NavList extends Component
{

     /**
     * The list.
     *
     * @var collection
     */
    public $list;

    /**
    * The depth of the list nesting.
    *
    * @var int
    */
    public $depth;

    /**
    * The level to be startet with displaying children of active items (useful for sub navigations).
    *
    * @var int
    */
    public $sublevel;

    /**
    * The Layout of the Nav. Can be horizontal, default is vertical.
    *
    * @var string
    */
    public $layout;

    /**
    * Children ul-lists are hidden but expandable via button click.
    *
    * @var boolean
    */
    public $expandable;

    /**
    * Children ul-lists are hidden but expandable via button click.
    *
    * @var boolean
    */
    public $dropdown;

    /**
    * Custom css class(es).
    *
    * @var string
    */
    public $class;

    /**
    * Custom css active class(es).
    *
    * @var string
    */
    public $active_class;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($list, $depth = null, $sublevel = 1, $layout = null, $expandable = false, $dropdown = null, $class = '', $active_class = 'fj--active')
    {
        $this->list = $list;
        $this->depth = $depth;
        $this->sublevel = $sublevel;
        $this->expandable = $expandable;
        $this->layout = $layout;
        $this->dropdown = $dropdown;
        $this->class = $class;
        $this->active_class = $active_class;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('fjord-ui::nav-list');
    }
}
