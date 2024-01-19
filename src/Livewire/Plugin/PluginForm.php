<?php

namespace Sokeio\Builder\Livewire\Plugin;

use Sokeio\Builder\Models\BuilderPlugin;
use Sokeio\Components\Form;
use Sokeio\Components\UI;

class PluginForm extends Form
{
    protected function  getModel()
    {
        return BuilderPlugin::class;
    }
    protected function getTitle()
    {
        return __('Builder Plugin');
    }
    ///'name', 'js', 'css', 'options', 'is_active'
    protected function FormUI()
    {
        return UI::Prex('data', [
            UI::Text('name')->Label(__('Name')),
            UI::Textarea('js')->Label(__('JS'))->ValueDefault('[]'),
            UI::Textarea('css')->Label(__('CSS'))->ValueDefault('[]'),
            UI::Textarea('options')->Label(__('Options'))->ValueDefault('[]'),
            UI::Checkbox('is_active')->Label(__('Active'))->Title(__('Active'))->ValueDefault(1)
        ])->ClassName('p-2');
    }
}
