<?php

namespace Sokeio\Builder\Livewire;

use Sokeio\Builder\FormBuilder;
use Sokeio\Cms\Models\Catalog;
use Sokeio\Cms\Models\Post;
use Sokeio\Cms\Models\Tag;
use Sokeio\Components\UI;

class PostBuilder extends FormBuilder
{
    public $categoryIds = [];
    public $tagIds = '';

    protected function getTitle()
    {
        return __('Post');
    }
    protected function FooterUI()
    {
        return [];
    }
    protected function loadDataAfter($post)
    {
        $this->categoryIds = $post->catalogs()->get()->map(function ($item) {
            return $item->id;
        })->toArray();
        $this->tagIds = json_encode($post->tags()->get()->map(function ($item) {
            return [
                'value' => $item->name,
                'id' => $item->id
            ];
        })->toArray());
    }
    protected function saveAfter($post)
    {
        $tagIds = collect(json_decode($this->tagIds, true))->map(function ($item) {
            if (isset($item['id'])) {
                return $item['id'];
            }

            $tag = Tag::create([
                'name' => is_string($item) ? $item : $item['value'],
                'author_id' => auth()->user()->id
            ]);
            $tag->save();
            return $tag->id;
        });

        $post->tags()->sync(
            collect($tagIds)
                ->filter(function ($item) {
                    return $item > 0;
                })
                ->toArray()
        );

        $post->catalogs()->sync(
            collect($this->categoryIds)
                ->filter(function ($item) {
                    return $item > 0;
                })
                ->toArray()
        );
    }
    protected function getPageList()
    {
        return route('admin.post');
    }
    protected function getLinkView()
    {
        return $this->data->slug ? route('post.slug', ['post' => $this->data->slug]) : '';
    }
    public function TagSearch($keyword)
    {
        return Tag::where('name', 'like', '%' . $keyword . '%')->get()->map(function ($item) {
            return ['value' => $item->name, 'id' => $item->id];
        });
    }
    protected function FormUI()
    {
        return UI::Prex('data', [
            UI::Row([
                UI::Column12([
                    UI::Hidden('content')->ValueDefault('')->required()->Label(__('Content')),
                    UI::Hidden('author_id')->ValueDefault(function () {
                        return auth()->user()->id;
                    }),
                    UI::Div(UI::Error('content')),
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
                    UI::Image('image')->Label(__('Image')),
                    UI::CheckboxMutil('categoryIds')->Prex('')->Label(__('Category'))->DataSource(function () {
                        return Catalog::query()->where('status', 'published')->get();
                    })->NoSave(),
                    UI::Tagify('tagIds')->Prex('')->Label(__('Tags'))->FieldOption(function () {
                        return [
                            'whitelistAction' => 'TagSearch',
                            'searchKeys' => ["name"]
                        ];
                    })->NoSave(),
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
                ]),
            ])
        ]);
    }
    protected function getModel()
    {
        return Post::class;
    }
}
