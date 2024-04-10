<?php

namespace Sokeio\Builder\Livewire\Template;

use Sokeio\Builder\Models\BuilderTemplate;
use Sokeio\Component;
use Sokeio\Facades\Shortcode;
use Sokeio\Facades\Theme;

class TemplatePreview extends Component
{
    public $dataId;
    public function mount()
    {
        Theme::setLayout('none');
        Shortcode::enable();
    }
    public function render()
    {
        $data = BuilderTemplate::find($this->dataId);
        if (!$data) {
            abort(404);
        }

        return view('builder::template.template-preview', [
            'template' => $data,
        ]);
    }
}
