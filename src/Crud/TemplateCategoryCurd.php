<?php

namespace Sokeio\Builder\Crud;

use Sokeio\Admin\Button;
use Sokeio\Admin\CrudManager;
use Sokeio\Admin\Item;
use Sokeio\Admin\ItemManager;
use Sokeio\Builder\Models\TemplateCategory;

class TemplateCategoryCurd extends CrudManager
{
    public function GetModel()
    {
        return TemplateCategory::class;
    }
    public function GetFields()
    {
        return [
            Item::Add('id')->Title('ID')->DisableFilter()->DisableSort()->When(function ($item, $manager) {
                return $manager->IsTable();
            })->DisableEdit(),
            Item::Add('name')->Title('Name')->Required(),
            Item::Add('slug')->Title('Slug')->Required(),
        ];
    }
    public function TablePage()
    {
        return ItemManager::Table()
            ->Model($this->GetModel())
            ->Title('Template Catagory Manager')
            // ->EditInTable()
            ->ButtonOnPage(function () {
                return [
                    Button::Create("Create Category")->ButtonType(function () {
                        return 'primary';
                    })->ModalUrl(function ($button) {
                        return "";
                        return route('admin.template-category-form');
                    })->ModalTitle('Create Category')
                ];
            })
            ->ButtonInTable(function () {
                return [
                    Button::Create("Edit")->ButtonType(function () {
                        return 'info';
                    })->ModalUrl(function ($button) {
                        return route('admin.role-form', ['dataId' => $button->getData()->id]);
                    })->ModalTitle('Edit Role'),
                    Button::Create("Permission")->ButtonType(function () {
                        return 'warning';
                    })->ModalUrl(function ($button) {
                        return route('admin.role-permission-form', ['dataId' => $button->getData()->id]);
                    })->ModalTitle('Permission Role'),
                    Button::Create("Remove")->ButtonType(function () {
                        return 'warning';
                    })->ConfirmTitle("Remove Role")->Confirm("Sure you wanna delete?")->WireClick(function ($button) {
                        $item = $button->getData();
                        return "callDoAction('deleteRow',{'id':" . $item->id . "})";
                    }),
                ];
            })
            ->Filter()
            ->Sort()
            ->CheckBoxRow()
            ->Item($this->GetFields());
    }
    public function FormPage()
    {
        return ItemManager::Form()
            ->Model($this->GetModel())
            ->Title('Category Form')
            ->Message(function ($manager) {
                if ($manager->getData()->getDataId() > 0) {
                    return 'Update Category success';
                }
                return 'Create Category success';
            })
            ->Item($this->GetFields());
    }
    public function SetupFormCustom()
    {
    }
}
