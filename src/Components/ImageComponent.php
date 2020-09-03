<?php

namespace Litstack\Bladesmith\Components;

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
     * Wether to lazy load images with base64 string.
     *
     * @var bool
     */
    public $lazy;

    /**
     * The images alt text.
     *
     * @var string
     */
    public $alt;

    /**
     * The images title.
     *
     * @var string
     */
    public $title;

    /**
     * css classes for the image.
     *
     * @var string
     */
    public $class;

    /**
     * Create new ImageComponent instance.
     *
     * @param  Media  $image
     * @param  bool   $lazy
     * @param  string $alt
     * @param  string $title
     * @param  string $class
     * @return void
     */
    public function __construct(Media $image, $lazy = true, $alt = null, $title = null, $class = '')
    {
        $this->image = $image;
        $this->alt = $this->getCustomProperty('alt', $alt);
        $this->title = $this->getCustomProperty('title', $title);
        $this->class = $class;
        $this->lazy = $lazy;
    }

    /**
     * Get custom property value or default.
     *
     * @param  string $property
     * @param  string $value
     * @return mixed
     */
    protected function getCustomProperty($property, $value = null)
    {
        return $value
            ?: $this->image->custom_properties[$property]
            ?? $this->image->custom_properties[app()->getLocale()][$property]
            ?? null;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
        return view('bladesmith::image');
    }
}
