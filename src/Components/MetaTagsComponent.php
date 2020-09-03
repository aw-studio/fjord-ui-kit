<?php

namespace Litstack\Bladesmith\Components;

use Illuminate\View\Component;

class MetaTagsComponent extends Component
{
    /**
     * The meta title.
     *
     * @var string
     */
    public $title;

    /**
     * The meta description.
     *
     * @var string
     */
    public $description;

    /**
     * The meta keywords.
     *
     * @var string
     */
    public $keywords;

    /**
     * Create a new component instance.
     *
     * @param  string|null $metaTitle
     * @param  string|null $metaDescription
     * @param  string|null $metaKeywords
     * @return void
     */
    public function __construct($title = null, $description = null, $keywords = null)
    {
        $this->title = $title;
        $this->description = $description;
        $this->keywords = $keywords;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('bladesmith::meta-tags');
    }
}
