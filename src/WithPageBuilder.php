<?php

namespace BytePlatform\Builder;

use BytePlatform\Facades\Theme;
use BytePlatform\Forms\WithFormData;

trait WithPageBuilder
{
    use WithFormData;

    protected function getPageTitle()
    {
        return 'Page Builder';
    }
    protected function getPageList()
    {
        return '';
    }
    protected function getOptions()
    {
        return BuilderManager::New()->getOptions();
    }

    public function doSaveBuilder()
    {
        $this->skipRender();
    }
    public function render()
    {
        Theme::setLayout('none');
        Theme::setTitle($this->getPageTitle(), true);
        return view('builder::page', [
            'options' => $this->getOptions(),
            'itemManager' => $this->getItemManager(),
            'templates' => TemplateBuilder::getTemplates(),
            'linkPageList' => $this->getPageList()
        ]);
    }
}
