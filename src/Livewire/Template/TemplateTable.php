<?php

namespace Sokeio\Builder\Livewire\Template;

use Sokeio\Builder\Models\BuilderTemplate;
use Sokeio\Components\Table;
use Sokeio\Components\UI;

class TemplateTable extends Table
{
    protected function  getModel()
    {
        return BuilderTemplate::class;
    }
    protected function getTitle()
    {
        return __('Builder Template');
    }
    protected function getRoute()
    {
        return 'admin.builder-template';
    }
    protected function getButtons()
    {
        return [
            UI::Button(__('Create With Builder'))->Route($this->getRoute() . '.add')
        ];
    }

    //The record has been deleted successfully.
    protected function getTableActions()
    {
        return [
            UI::ButtonEdit(__('Edit With Builder'))->Route($this->getRoute() . '.edit', function ($row) {
                return [
                    'dataId' => $row->id
                ];
            }),
            UI::ButtonRemove(__('Remove'))->Confirm(__('Do you want to delete this record?'), 'Confirm')->WireClick(function ($item) {
                return 'doRemove(' . $item->getDataItem()->id . ')';
            })
        ];
    }
    protected function getQuery()
    {
        return parent::getQuery()->Where(function ($query) {
            $query->orWhere('only_me', 0);
            $query->orWhere(function ($subQuery) {
                $subQuery->where('only_me', true);
                $subQuery->Where('author_id', auth()->user()->id);
            });
        });
    }
    public function doChangeStatus($id, $status)
    {
        $this->getQuery()->where('id', $id)->update(['is_active' => $status]);
    }
    protected function getColumns()
    {
        return [
            UI::Text('name')->Label(__('Name')),
            UI::Text('Category')->Label(__('Category')),
            UI::Text('topic')->Label(__('Topic')),
            UI::Text('only_me')->Label(__('Only me'))->ValueDefault(0)->NoSort(),

        ];
    }
}
