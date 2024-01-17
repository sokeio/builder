<?php

namespace Sokeio\Builder\Livewire;

use Sokeio\Builder\FormBuilder;
use Sokeio\Cms\Models\Page;
use Sokeio\Components\UI;

class PageBuilder extends FormBuilder
{
    protected function getTitle()
    {
        return __('Page');
    }
    protected function FooterUI()
    {
        return [];
    }

    protected function getPageList()
    {
        return route('admin.page');
    }
    protected function getLinkView()
    {
        return $this->data->slug ? route('page.slug', ['page' => $this->data->slug]) : '';
    }
    protected function FormUI()
    {
        return UI::Prex('data', UI::Row([
            UI::Column12([
                UI::Hidden('content')->ValueDefault(''),
                UI::Hidden('author_id')->ValueDefault(function () {
                    return auth()->user()->id;
                }),
                UI::Text('name')->Label(__('Title'))->required(),
                UI::Text('slug')->Label(__('Slug')),

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
                // UI::DatePicker('published_at')->Label(__('Published At')),
                UI::Image('image')->Label(__('Image')),

                UI::Select('layout')->Label(__('Layout'))->DataSource(function () {
                    return [
                        [
                            'id' => 'default',
                            'name' => __('Default')
                        ],
                        [
                            'id' => 'none',
                            'name' => __('None')
                        ],
                    ];
                }),
                UI::Textarea('description')->Label(__('Description')),
                UI::Textarea('custom_js')->Label(__('Custom Js')),
                UI::Textarea('custom_css')->Label(__('Custom CSS')),
                UI::Button(__('Save article'))->WireClick('doSave()')->ClassName('w-100 mb-2'),
            ])
        ]));
    }
    protected function getModel()
    {
        return Page::class;
    }
}
