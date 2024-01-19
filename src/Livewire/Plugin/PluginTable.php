<?php

namespace Sokeio\Builder\Livewire\Plugin;

use Sokeio\Builder\Models\BuilderPlugin;
use Sokeio\Components\Table;
use Sokeio\Components\UI;

class PluginTable extends Table
{
    protected function  getModel()
    {
        return BuilderPlugin::class;
    }
    protected function getTitle()
    {
        return __('Builder Plugin');
    }
    protected function getRoute()
    {
        return 'admin.builder-plugin';
    }
    public function doChangeStatus($id, $status)
    {
        $this->getQuery()->where('id', $id)->update(['is_active' => $status]);
    }
    protected function getColumns()
    {
        return [
            UI::Text('name')->Label(__('Name')),
            UI::Textarea('js')->Label(__('JS'))->ValueDefault('[]'),
            UI::Textarea('css')->Label(__('CSS'))->ValueDefault('[]'),
            UI::Textarea('options')->Label(__('Options'))->ValueDefault('[]'),
            UI::Button('is_active')->Label(__('Active'))->Title(__('Active'))->NoSort()->WireClick(function ($item) {
                if ($item->getDataItem()->is_active === true) {
                    $item->Title(__('Active'));
                    $item->Primary();
                } else {
                    $item->Title(__('Block'));
                    $item->Warning();
                }
                return 'doChangeStatus(' . $item->getDataItem()->id . ',' . ($item->getDataItem()->status === true ? 0 : 1) . ')';
            })
        ];
    }
}
