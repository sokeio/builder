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
            Item::Add('status')->Title('status')->DataOptionStatus()->DataText(function (Item $item) {
                $button = $item->ConvertToButton()
                    ->Title(function ($button) {
                        $item = $button->getData();
                        return $item->status ? 'Active' : 'Block';
                    })->ButtonType(function ($button) {
                        $item = $button->getData();
                        return $item->status ? 'success' : 'danger';
                    });
                if ($button->getWhen()) {
                    $button->WireClick(function ($button) {
                        $item = $button->getData();
                        return "callDoAction('changeStatus',{'id':" . $item->id . ",'status':" . ($item->status == 1 ? 0 : 1) . "})";
                    });
                }
                return $button->render();
            })->DisableEdit(function ($item, $manager) {
                return !$manager->IsTable();
            }),
        ]);
    }
    public $dataId = null;
    public function doSaveBuilder()
    {

        $this->showMessage('demo');
        $this->skipRender();
    }
}
