<?php

namespace Sokeio\Builder\Livewire\Template;

use Sokeio\Builder\FormBuilder;
use Sokeio\Builder\Models\BuilderTemplate;
use Sokeio\Components\UI;

class TemplateForm extends FormBuilder
{
    protected function  getModel()
    {
        return BuilderTemplate::class;
    }
    protected function getTitle()
    {
        return __('Builder Template');
    }
    protected function getPageList()
    {
        return route('admin.builder-template');
    }
    ///'name', 'js', 'css', 'options', 'is_active'
    protected function FormUI()
    {
        return UI::Prex('data', [
            UI::Hidden('author_id')->ValueDefault(function () {
                return auth()->user()->id;
            }),
            UI::Hidden('content')->ValueDefault(''),
            UI::Text('name')->Label(__('Name'))->required(),
            UI::Image('thumbnail')->Label(__('Thumbnail')),
            UI::Text('category')->Label(__('Category'))->ValueDefault('common')->required(),
            UI::Text('topic')->Label(__('Topic'))->required(),
            UI::Textarea('description')->Label(__('Description'))->ValueDefault(''),
            UI::Checkbox('only_me')->Label(__('Only me'))->Title(__('Only me use this template'))->ValueDefault(0),
            UI::Text('email')->Label(__('Email')),
            UI::Select('status')->Label(__('Status'))->DataSource(function () {
                return [
                    [
                        'id' => 'draft',
                        'name' => __('Draft')
                    ],
                    [
                        'id' => 'published',
                        'name' => __('Published')
                    ]
                ];
            })->ValueDefault('published'),
        ]);
    }
}
