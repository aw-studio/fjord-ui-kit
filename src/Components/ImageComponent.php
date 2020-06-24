<?php

namespace Fjord\Ui\Components;

use Fjord\Crud\Models\Media;
use Illuminate\View\Component;

class ImageComponent extends Component
{
    /**
     * The image.
     *
     * @var string
     */
    public $image;

    /**
     * The images alt text.
     *
     * @var string
     */
    public $alt;

    /**
     * css classes for the image.
     *
     * @var string
     */
    public $class;

    /**
     * Create new ImageComponent instance.
     *
     * @param Media $image
     * @param string $alt
     * @param string $class
     */
    public function __construct(Media $image, $alt = '', $class = '')
    {
        $this->image = $image;
        $this->alt = $alt;
        $this->class = $class;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('fjord-ui::image');
    }
}
