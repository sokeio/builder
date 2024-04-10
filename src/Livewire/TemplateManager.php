<?php

namespace Sokeio\Builder\Livewire;

use Illuminate\Support\Facades\Blade;
use Sokeio\Builder\TemplateBuilder;
use Sokeio\Component;
use Sokeio\Facades\Assets;
use Sokeio\Facades\Shortcode;

class TemplateManager extends Component
{
    public $callbackEvent;
    public function mount()
    {
        $this->callbackEvent = request('callbackEvent');
        if ($this->currentIsPage()) {
            Assets::setTitle(__('Template Viewer'));
        }
    }
    public function viewTemplate($template)
    {
        Shortcode::enable();
        $html = Blade::render($template);
        $this->skipRender();
        Shortcode::disable();
        return $html;
    }
    public function getTemplates()
    {
        $this->skipRender();
        return TemplateBuilder::getTemplates();
    }
    public function render()
    {
        return view('builder::template-manager.index', [
            'isPage' => $this->currentIsPage()
        ]);
    }
}
