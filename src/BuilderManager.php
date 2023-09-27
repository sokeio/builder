<?php

namespace BytePlatform\Builder;

use BytePlatform\Builder\Blocks\Bootstrap\BootstrapCollectionBlock;
use BytePlatform\Builder\Blocks\Common\CommonCollectionBlock;
use BytePlatform\ItemCallback;

class BuilderManager extends ItemCallback
{
    private $callbackBlocks = [];
    public function __construct()
    {
        $this->Manager($this)
            ->addBlocks(BootstrapCollectionBlock::getBlockArray())
            ->addBlocks(CommonCollectionBlock::getBlockArray());
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
                'js' => [url('platform/modules/Builder/grapesjs-byte-builder/dist/index.js')],
                'css' => [],
                'options' => [
                    'urlTemplateManager' => route('admin.builder.template-manager')
                ]
            ], ...$this->getPlugins()],
            'blockManager' => [
                'appendTo' => '.byte-builder-manager .block-manager',
                // 'blocks' => $this->getBlocks()
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
                'scripts' => ['https://getbootstrap.com/docs/5.3/dist/js/bootstrap.bundle.min.js'],
                'styles' => ['https://getbootstrap.com/docs/5.3/dist/css/bootstrap.min.css'],
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
            //     'name' => 'grapesjs-project-manager',
            //     'js' => ['https://unpkg.com/grapesjs-project-manager'],
            //     'css' => ['https://unpkg.com/grapesjs-project-manager/dist/grapesjs-project-manager.min.css'],
            //     'options' => []
            // ]
        ]) ?? []; //
    }
}
