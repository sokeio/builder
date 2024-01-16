<?php

namespace Sokeio\Builder;

use PhpParser\Node\Expr\FuncCall;
use Sokeio\Builder\Models\BuilderPlugin;
use Sokeio\Components\Form;
use Sokeio\Facades\Theme;

class FormBuilder extends Form
{
    public $tabIndex = 0;
    public function ConvertShortcodeToHtml($content)
    {
        $this->skipRender();
        return shortcode_render($content);
    }
    public function getTemplates()
    {
        return TemplateBuilder::getTemplates();
    }
    protected function getView()
    {
        Theme::setTitle($this->getTitle());
        Theme::setLayout('none');
        breadcrumb()->Title($this->getTitle())->Breadcrumb($this->getBreadcrumb());
        return 'builder::components.page';
    }
    protected function getPlugins()
    {
        return [[
            'name' => 'grapesjs-sokeio',
            'js' => [url('platform/modules/CmsBuilder/grapesjs-sokeio/dist/index.js')],
            'css' => [],
            'options' => [
                'urlTemplateManager' => '' // route('admin.builder.template-manager')
            ]
        ], ...apply_filters('SOKEIO_BUILDER_PLUGINS', [
            [
                'name' => 'gjs-blocks-basic',
                'js' => ['https://unpkg.com/grapesjs-blocks-basic'],
                'css' => [],
                'options' => [
                    'flexGrid' => true
                ]
            ],
            [
                'name' => 'grapesjs-plugin-forms',
                'js' => ['https://unpkg.com/grapesjs-plugin-forms'],
                'css' => [],
                'options' => []
            ],
            ...BuilderPlugin::query()->get()->map(function ($plugin) {
                return [
                    'name' => $plugin->name,
                    'js' => json_decode($plugin->js, true),
                    'css' => json_decode($plugin->css, true),
                    'options' => json_decode($plugin->options, true)
                ];
            })
        ])];
    }
    public function render()
    {
        return view($this->getView(), [
            'title' => $this->getTitle(),
            // 'layout' => $this->layout,
            // 'footer' => $this->footer,
            'builder_version' => 'v1.0.0',
            'linkPageList' => '/',
            'linkView' => '/',
            'tabs' => [
                ['title' => __('Blocks'), 'template' => true, 'view' => 'builder::tabs.block', 'icon' => ''],
                ['title' => __('Templates'), 'template' => true, 'view' => 'builder::tabs.template', 'icon' => ''],
                ['title' => __('Settings'), 'template' => false, 'view' => 'builder::tabs.settings', 'icon' => ''],
            ],
            'options' => [
                'pluginManager' => $this->getPlugins(),
                'blockManager' => [
                    'appendTo' => '.sokeio-builder-manager .block-manager',
                ],
                'selectorManager' => ['appendTo' => '.sokeio-builder-manager .selector-manager',],
                'styleManager' => [
                    'appendTo' => '.sokeio-builder-manager .style-manager',
                ],
                'layerManager' => [
                    'appendTo' => '.sokeio-builder-manager .layer-manager',
                ],
                'deviceManager' => [
                    // 'devices' => null
                    'appendTo' => '.sokeio-builder-manager .device-manager',
                ],
                'traitManager' => [
                    'appendTo' => '.sokeio-builder-manager .trait-manager',
                ],
                'panels' => [
                    'defaults' => [
                        [
                            'id' => 'options',
                            'el' => '.sokeio-builder-manager .options-panel-manager'
                        ],
                        [
                            'id' => 'devices-c',
                            'el' => '.sokeio-builder-manager .devices-panel-manager'
                        ]
                    ]
                ],
                'canvas' => [
                    'scripts' => ['https://cdn.jsdelivr.net/npm/@tabler/core@latest/dist/js/tabler.min.js'],
                    'styles' => [
                        'https://cdn.jsdelivr.net/npm/@tabler/core@latest/dist/css/tabler.min.css',
                        'https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css'
                    ],
                    'frameStyle' => `
    
                    body { background-color: #fff }
                    * ::-webkit-scrollbar-track { background: rgba(0, 0, 0, 0.1) }
                    * ::-webkit-scrollbar-thumb { background: rgba(255, 255, 255, 0.2) }
                    * ::-webkit-scrollbar { width: 10px }
                    *[data-gjs-type="shortcode"] {
                        min-height: 50px;
                        padding: 10px;
                        border: 1px dashed #ccc;
                    }
                  `
                ],
                'height' => '100%',
                'assetManager' => false,

                'storageManager' => false,

            ],
            'formUIClass' => $this->getFormClass()
        ]);
    }
}
