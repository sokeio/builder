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
}
