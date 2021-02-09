<?php

namespace Litstack\Bladesmith\Components;

use Ignite\Crud\Models\Media;
use Illuminate\View\Component;
use InvalidArgumentException;

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
     * Create new ImageComponent instance.
     *
     * @param  Media  $image
     * @param  bool   $lazy
     * @param  string $alt
     * @param  string $title
     * @param  string $class
     * @return void
     */
    public function __construct(Media $image = null, $lazy = true, $alt = null, $title = null, $class = '')
    {
        if ($image == new Media) {
            throw new InvalidArgumentException('Missing [image] attribute for '.static::class);
        }

        $this->image = $image;
        $this->class = $class;
        $this->lazy = $lazy;
        if ($image) {
            $this->alt = $this->getCustomProperty('alt', $alt);
            $this->title = $this->getCustomProperty('title', $title);
            $this->conversions = $this->getMediaConversions();
            $this->thumbnail = $this->makeThumbnail($image);
        }
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
        $conversions = $this->getCustomProperty('generated_conversions', false);

        if (is_null($conversions)) {
            $conversions = $this->image->generated_conversions;
        }

        return collect($conversions)
            // Value is false when the conversion has not been generated.
            ->filter(fn ($value) => $value == true)
            // Only use versions that are specified in the lit config
            ->filter(fn ($value, $conversion) => array_key_exists($conversion, config('lit.mediaconversions.default')))
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
     * @return bool
     */
    public function exists(): bool
    {
        if (! $this->image) {
            return false;
        }

        return file_exists($this->image->getPath());
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
