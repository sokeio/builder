<?php

namespace Sokeio\Builder\Livewire;

use Sokeio\Builder\FormBuilder;
use Sokeio\Cms\Models\Page;
use Sokeio\Components\UI;

class PageBuilder extends FormBuilder
{
    protected function getTitle()
    {
        return __('Page');
    }
    protected function FormUI()
    {
        return UI::Div([]);
    }
    protected function getModel()
    {
        return Page::class;
    }
}
