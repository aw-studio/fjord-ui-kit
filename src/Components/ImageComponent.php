<?php

namespace Litstack\Bladesmith\Components;

use Ignite\Crud\Models\Media;
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
     * generated conversions for the image.
     *
     * @var string
     */
    public $conversions;

    /**
     * smallest conversion of the image.
     *
     * @var string
     */
    public $thumbnail;

    /**
     * check existance of exists.
     *
     * @var string
     */
    public $exists;

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
        $this->conversions = $this->getMediaConversions();
        $this->thumbnail = $this->makeThumbnail($image);
        $this->exists = $this->exists($image);
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
     * Get the generated media conversions.
     *
     * @return Collection
     */
    protected function getMediaConversions()
    {
        return collect($this->getCustomProperty('generated_conversions', false))
            ->filter(fn ($value) => $value == true)
            ->keys()
            ->mapWithKeys(function ($conversion) {
                return [$conversion => config('lit.mediaconversions.default')[$conversion][0]];
            });
    }

    /**
     * Get the smallest generated media conversion
     * and return a base 64 string of it.
     *
     * @return Collection
     */
    protected function makeThumbnail($image)
    {
        if (! $conversion = $this->getMediaConversions()->sort()->keys()->first()) {
            return;
        }

        return b64($image->getPath($conversion));
    }

    /**
     * Check if the image exists.
     *
     * @param  Media $image
     * @return bool
     */
    protected function exists($image): bool
    {
        return file_exists($image->getPath());
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
