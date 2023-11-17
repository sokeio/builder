<?php

namespace BytePlatform\Builder\Livewire\Template;

use BytePlatform\Admin\ItemManager;
use BytePlatform\Builder\Models\TemplateBuilder;
use BytePlatform\Builder\WithPageBuilder;
use BytePlatform\Component;
use BytePlatform\Item;

class Builder extends Component
{
    use WithPageBuilder;
    protected function getTabs()
    {
        return apply_filters('BYTE_BUILDER_TABS', [
            [
                'icon' => '<svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-apps" width="24"
                height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                stroke-linecap="round" stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                <path d="M4 4m0 1a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v4a1 1 0 0 1 -1 1h-4a1 1 0 0 1 -1 -1z"></path>
                <path d="M4 14m0 1a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v4a1 1 0 0 1 -1 1h-4a1 1 0 0 1 -1 -1z"></path>
                <path d="M14 14m0 1a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v4a1 1 0 0 1 -1 1h-4a1 1 0 0 1 -1 -1z"></path>
                <path d="M14 7l6 0"></path>
                <path d="M17 4l0 6"></path>
            </svg>',
                'title' => 'Block Manager',
                'view' => 'builder::tabs.block'
            ],
            [
                'icon' => '<svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-carousel-vertical"
                width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                fill="none" stroke-linecap="round" stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                <path d="M19 8v8a1 1 0 0 1 -1 1h-12a1 1 0 0 1 -1 -1v-8a1 1 0 0 1 1 -1h12a1 1 0 0 1 1 1z"></path>
                <path d="M7 22v-1a1 1 0 0 1 1 -1h8a1 1 0 0 1 1 1v1"></path>
                <path d="M17 2v1a1 1 0 0 1 -1 1h-8a1 1 0 0 1 -1 -1v-1"></path>
            </svg>',
                'template' => true,
                'title' => 'Template Manager',
                'view' => 'builder::tabs.template'
            ],
            [
                'icon' => '<svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-table-options"
                width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                fill="none" stroke-linecap="round" stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                <path d="M12 21h-7a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h14a2 2 0 0 1 2 2v7"></path>
                <path d="M3 10h18"></path>
                <path d="M10 3v18"></path>
                <path d="M19.001 19m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0"></path>
                <path d="M19.001 15.5v1.5"></path>
                <path d="M19.001 21v1.5"></path>
                <path d="M22.032 17.25l-1.299 .75"></path>
                <path d="M17.27 20l-1.3 .75"></path>
                <path d="M15.97 17.25l1.3 .75"></path>
                <path d="M20.733 20l1.3 .75"></path>
            </svg>',
                'title' => 'Template Setting',
                'view' => 'builder::tabs.setting'
            ]
        ]);
    }
    protected function getLinkPageList()
    {
        return route('admin.builder.template');
    }
    protected function ItemManager()
    {
        return ItemManager::Form()->Model(TemplateBuilder::class)->Item([
            Item::Add('name')->Column(Item::Col12)->Title('Title')->Required(),

            Item::Add('description')->Column(Item::Col12)->Type('textarea')->Title('Description'),
            Item::Add('image')->Column(Item::Col12)->Type('images')->Title('Image'),
            Item::Add('custom_css')->Title('Css')->Type('textarea')->Column(Item::Col12),
            Item::Add('custom_js')->Title('Js')->Type('textarea')->Column(Item::Col12),
            Item::Add('css')->InputHidden(),
            Item::Add('js')->InputHidden(),
            Item::Add('is_public')->Title('Public Share')->DataOptionStatus()->Column(Item::Col12)->ValueDefault(function () {
                return 0;
            }),
            Item::Add('status')->Title('Status')->DataOptionStatus()->Column(Item::Col12)->ValueDefault(function () {
                return 1;
            }),
            Item::Add('content')->Column(Item::Col12)->InputHidden(),
            Item::Add('author_id')->Column(Item::Col12)->InputHidden()->ValueDefault(function () {
                return auth()->user()->id;
            }),

        ])
            ->BeforeSave(function ($model) {
                $model->author_id = auth()->user()->id;
                return $model;
            });
    }
    public function doSaveBuilder()
    {
        try {
            $model = $this->form->DataFromForm();
            if (!$this->dataId) {
                $this->showMessage('Save Data Successfull');
                return redirect(route('admin.builder.template-edit', ['dataId' => $model->id]));
            } else {
                $this->showMessage('Save Data Successfull');
            }
        } catch (\Exception $ex) {
            $this->tabIndex = 2;
            throw $ex;
        }
    }
}
