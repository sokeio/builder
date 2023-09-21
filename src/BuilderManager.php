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
            'pluginManager' => $this->getPlugins(),
            'blockManager' => [
                // 'appendTo' => '#blocks',
                // 'blocks' => $this->getBlocks()
            ],
            'selectorManager' => [],
            'styleManager' => [],
            'deviceManager' => [
                // 'devices' => null
            ],
            'panels' => [],
            'storageManager' => false
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
                'name' => 'grapesjs-shortcode',
                'js' => [url('platform/modules/Builder/grapesjs-shortcode/dist/index.js')],
                'css' => [],
                'options' => []
            ],
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
            ]
        ]);
    }
}
