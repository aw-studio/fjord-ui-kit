<?php

namespace Fjord\Ui\Components;

use Illuminate\View\Component;
use Fjord\Support\Facades\Form;

class MetaTags extends Component
{
    public $metaTitle;
    public $metaDescription;
    public $metaKeywords;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($metaTitle = null, $metaDescription = null, $metaKeywords = null)
    {
        $settings = null;

        if (!$metaTitle || !$metaDescription || !$metaKeywords) {
            $settings = Form::load('collections', 'settings');
        }

        $this->metaTitle = $metaTitle ?? $settings->metaTitle ?? '';
        $this->metaDescription = $metaDescription ?? $settings->metaDescription ?? '';
        $this->metaKeywords = $metaKeywords ?? $settings->metaKeywords ?? '';
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('fjord-ui::meta-tags');
    }
}
