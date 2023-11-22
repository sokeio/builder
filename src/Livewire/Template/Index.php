<?php

namespace Sokeio\Builder\Livewire\Template;

use Sokeio\Builder\TemplateBuilder;
use Sokeio\Component;

class Index extends Component
{
    public $callbackEvent;
    public function mount()
    {
        $this->callbackEvent = request('callbackEvent');
    }
    public function getTemplates()
    {
        $this->skipRender();
        return TemplateBuilder::getTemplates();

    }
    public function render()
    {
        return view('builder::template.index', []);
    }
}
