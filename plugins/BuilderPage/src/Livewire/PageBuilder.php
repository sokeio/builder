<?php

namespace BytePlugin\BuilderPage\Livewire;

use BytePlatform\Builder\WithPageBuilder;
use BytePlatform\Component;

class PageBuilder extends Component
{
    use WithPageBuilder;
    public $dataId = null;
    public function doSaveBuilder()
    {
        $this->showMessage('demo');
        $this->skipRender();
    }
}
