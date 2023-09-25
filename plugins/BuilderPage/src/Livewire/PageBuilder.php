<?php

namespace BytePlugin\BuilderPage\Livewire;

use BytePlatform\Builder\WithPageBuilder;
use BytePlatform\Component;
use BytePlatform\Item;
use BytePlatform\ItemManager;
use BytePlugin\BuilderPage\Models\PageBuilder as PageBuilderModel;

class PageBuilder extends Component
{
    use WithPageBuilder;

    protected function ItemManager()
    {
        return ItemManager::Form()->Model(PageBuilderModel::class)->Item([
            Item::Add('name')->Column(Item::Col12)->Title('Title')->Required(),
            Item::Add('slug')->Column(Item::Col12)->Title('Slug')->Required(),
            Item::Add('description')->Column(Item::Col12)->Type('textarea')->Title('Description')->Required(),
            Item::Add('published_at')->Column(Item::Col12)->Type('flatpickr')->Title('Published At'),
            Item::Add('status')->Title('Status')->DataOptionStatus()->Column(Item::Col12),
        ]);
    }
    public $dataId = null;
    public function doSaveBuilder()
    {

        $this->showMessage('demo');
        $this->skipRender();
    }
}
