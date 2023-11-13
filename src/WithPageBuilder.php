<?php

namespace BytePlatform\Builder;

use BytePlatform\Facades\Theme;
use BytePlatform\Admin\Concerns\WithFormData;

trait WithPageBuilder
{
    use WithFormData;
    public $tabIndex = 0;
    public $builder_version = 'v1.0.2';
    protected $queryString = [
        'tabIndex' => ['except' => 0],
    ];
    protected function getPageTitle()
    {
        return 'Page Builder';
    }
    protected function getLinkPageList()
    {
        return '';
    }
    protected function getOptions()
    {
        return BuilderManager::New()->getOptions();
    }

    public function ConvertShortcodeToHtml($content)
    {
        $this->skipRender();
        return shortcode_render($content);
    }
    public function doSaveBuilder()
    {
        $this->skipRender();
    }
    public function getLinkView()
    {

        if ($this->form->slug)
            return route('page-builder.slug', ['slug' => $this->form->slug]);
        return "";
    }
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
                'title' => 'Page Setting',
                'view' => 'builder::tabs.setting'
            ],
            [
                'icon' => '<svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-seo" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                <path d="M7 8h-3a1 1 0 0 0 -1 1v2a1 1 0 0 0 1 1h2a1 1 0 0 1 1 1v2a1 1 0 0 1 -1 1h-3"></path>
                <path d="M14 16h-4v-8h4"></path>
                <path d="M11 12h2"></path>
                <path d="M17 8m0 1a1 1 0 0 1 1 -1h2a1 1 0 0 1 1 1v6a1 1 0 0 1 -1 1h-2a1 1 0 0 1 -1 -1z"></path>
             </svg>',
                'title' => 'SEO Setting',
                'view' => 'builder::tabs.seo'
            ]
        ]);
    }
    public function getTemplates()
    {
        $this->skipRender();
        return apply_filters('BYTE_BUILDER_TEMPLATES', TemplateBuilder::getTemplates());
    }
    public function render()
    {
        Theme::setLayout('none');
        Theme::setTitle($this->getPageTitle(), true);
        return view('builder::page', [
            'options' => apply_filters('BYTE_BUILDER_OPTIONS', $this->getOptions()),
            'itemManager' =>  apply_filters('BYTE_BUILDER_ITEMS', $this->getItemManager()),
            'templates' => [],
            'linkPageList' => $this->getLinkPageList(),
            'tabs' => $this->getTabs(),
            'linkView' => $this->getLinkView()
        ]);
    }
}
