<?php

namespace BytePlatform\Builder;

use BytePlatform\Facades\Theme;

trait WithPageBuilder
{
    public $cssdata = ".wellcome-page{color: red;width:100%;min-height:100px;}";
    public $htmldata = "<div class='wellcome-page'>Wellcome To Page Builder</div>";

    public function getOptions()
    {
        return [
            'blockManager' => [
                'blocks' => [
                    [
                        'category' => 'basic',
                        'id' => 'section',
                        'label' => '<b>Section</b>',
                        'attributes' => ['class' => 'gjs-block-section'],
                        'media' => '<svg viewBox="0 0 24 24">
        <path fill="currentColor" d="M3.9,12C3.9,10.29 5.29,8.9 7,8.9H11V7H7A5,5 0 0,0 2,12A5,5 0 0,0 7,17H11V15.1H7C5.29,15.1 3.9,13.71 3.9,12M8,13H16V11H8V13M17,7H13V8.9H17C18.71,8.9 20.1,10.29 20.1,12C20.1,13.71 18.71,15.1 17,15.1H13V17H17A5,5 0 0,0 22,12A5,5 0 0,0 17,7Z" />
      </svg>',
                        'content' => "<section>
                        <h1>This is a simple title</h1>
                        <div>This is just a Lorem text: Lorem ipsum dolor sit amet</div>
                      </section>",
                    ],
                    [
                        'category' => 'basic',
                        'id' => 'text',
                        'label' => 'Text',
                        'content' => '<div data-gjs-type="text">Insert your text here</div>',

                    ],
                    [
                        'id' => 'image',
                        'label' =>  'Image',
                        // Select the component once it's dropped
                        'select' =>  true,
                        // You can pass components as a JSON instead of a simple HTML string,
                        // in this case we also use a defined component type `image`
                        'content' =>  ['type' => 'image'],
                        // This triggers `active` event on dropped components and the `image`
                        // reacts by opening the AssetManager
                        'activate' =>  true
                    ]

                ]
            ]
        ];
    }
    public function doSaveBuilder()
    {
        $this->showMessage($this->cssdata);
        $this->skipRender();
    }
    public function render()
    {
        Theme::setLayout('none');
        return view('builder::page', [
            'options' => $this->getOptions()
        ]);
    }
}
