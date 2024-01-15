<?php

namespace Sokeio\Builder;

use Sokeio\Components\Form;

class FormBuilder extends Form
{
    public function ConvertShortcodeToHtml($content)
    {
        $this->skipRender();
        return shortcode_render($content);
    }
    public function render()
    {
        return view($this->getView(), [
            'title' => $this->getTitle(),
            'layout' => $this->layout,
            'footer' => $this->footer,
            'formUIClass' => $this->getFormClass()
        ]);
    }
}
