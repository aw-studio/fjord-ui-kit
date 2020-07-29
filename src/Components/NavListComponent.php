<?php

namespace Fjord\Ui\Components;

use Fjord\Crud\Fields\ListField\ListCollection;
use Illuminate\View\Component;

class NavListComponent extends Component
{
    /**
     * The list.
     *
     * @var ListCollection
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
     * @var bool
     */
    public $expandable;

    /**
     * Children ul-lists are hidden but expandable via button click.
     *
     * @var bool
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
     * Create new NavList instance.
     *
     * @param  ListCollection $list
     * @param  int|null       $depth
     * @param  int            $sublevel
     * @param  string|null    $layout
     * @param  bool           $expandable
     * @param  bool           $dropdown
     * @param  string         $class
     * @param  string         $active_class
     * @return void
     */
    public function __construct(ListCollection $list,
                                $depth = null,
                                $sublevel = 1,
                                $layout = null,
                                $expandable = false,
                                $dropdown = false,
                                $class = '',
                                $active_class = 'fj--active')
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
