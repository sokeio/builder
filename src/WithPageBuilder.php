<?php

namespace BytePlatform\Builder;

use BytePlatform\Facades\Theme;

trait WithPageBuilder
{
    public $jsdata = '';
    public $cssdata = ".wellcome-page{color: red;width:100%;min-height:100px;}";
    public $htmldata = "<div class='wellcome-page'>Wellcome To Page Builder</div>";
    protected function getPageTitle()
    {
        return 'Page Builder';
    }
    protected function getOptions()
    {
        return BuilderManager::New()->getOptions();
    }

    public function doSaveBuilder()
    {
        $this->showMessage($this->cssdata);
        $this->skipRender();
    }
    public function render()
    {
        Theme::setLayout('none');
        Theme::setTitle($this->getPageTitle(), true);
        return view('builder::page', [
            'options' => $this->getOptions()
        ]);
    }
}
