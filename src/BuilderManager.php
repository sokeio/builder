<?php

namespace Sokeio\Builder;

use Sokeio\ItemCallback;

class BuilderManager extends ItemCallback
{
    private $callbackBlocks = [];
    public function __construct()
    {
    }
    public function addBlocks($blocks)
    {
        if (!is_array($blocks)) $blocks = [$blocks];
        $this->callbackBlocks = [...$this->callbackBlocks, ...$blocks];
        return $this;
    }
    public function getOptions()
    {
        return [
            'pluginManager' => [[
                'name' => 'grapesjs-byte-builder',
                'js' => [url('platform/modules/builder/grapesjs-byte-builder/dist/index.js')],
                'css' => [],
                'options' => [
                    'urlTemplateManager' => route('admin.builder.template-manager')
                ]
            ], ...$this->getPlugins()],
            'blockManager' => [
                'appendTo' => '.byte-builder-manager .block-manager',
            ],
            'selectorManager' => ['appendTo' => '.byte-builder-manager .selector-manager',],
            'styleManager' => [
                'appendTo' => '.byte-builder-manager .style-manager',
            ],
            'layerManager' => [
                'appendTo' => '.byte-builder-manager .layer-manager',
            ],
            'deviceManager' => [
                // 'devices' => null
                'appendTo' => '.byte-builder-manager .device-manager',
            ],
            'traitManager' => [
                'appendTo' => '.byte-builder-manager .trait-manager',
            ],
            'panels' => [
                'defaults' => [
                    [
                        'id' => 'options',
                        'el' => '.byte-builder-manager .options-panel-manager'
                    ],
                    [
                        'id' => 'devices-c',
                        'el' => '.byte-builder-manager .devices-panel-manager'
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

        ];
    }
    public function getBlocks()
    {
        return collect($this->callbackBlocks)->map(function ($item) {
            $item2 = $this->getValueByCallback($item);
            if ($item2)
                return $item2;

            return null;
        })->where(function ($item) {
            return $item != null;
        })->toArray();
    }
    /**
        'gjs-blocks-basic',
        'grapesjs-plugin-forms',
        'grapesjs-component-countdown',
        'grapesjs-plugin-export',
        'grapesjs-tabs',
        'grapesjs-custom-code',
        'grapesjs-touch',
        'grapesjs-parser-postcss',
        'grapesjs-tooltip',
        'grapesjs-tui-image-editor',
        'grapesjs-typed',
        'grapesjs-style-bg',
        'grapesjs-preset-webpage',
     */
    public function getPlugins()
    {
        return apply_filters('BYTE_BUILDER_PLUGINS', [
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
            // [
            //     'name' => 'grapesjs-bootstrap',
            //     'js' => ['https://unpkg.com/grapesjs-bootstrap'],
            //     'css' => [],
            //     'options' => []
            // ]
            // [
            //     'name' => 'grapesjs-project-manager',
            //     'js' => ['https://unpkg.com/grapesjs-project-manager'],
            //     'css' => ['https://unpkg.com/grapesjs-project-manager/dist/grapesjs-project-manager.min.css'],
            //     'options' => []
            // ]
        ]) ?? []; //
    }
}
