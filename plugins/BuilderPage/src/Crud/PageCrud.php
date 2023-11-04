<?php

namespace BytePlugin\BuilderPage\Crud;

use BytePlatform\Button;
use BytePlatform\CrudManager;
use BytePlatform\Item;
use BytePlatform\ItemManager;
use BytePlugin\BuilderPage\Models\PageBuilder;

class PageCrud extends CrudManager
{
    public function GetModel()
    {
        return PageBuilder::class;
    }
    public function GetFields()
    {
        return [
            Item::Add('id')->Title('ID')->DisableFilter()->DisableSort()->When(function ($item, $manager) {
                return $manager->IsTable();
            })->DisableEdit(),
            Item::Add('name')->Column(Item::Col12)->Title('Name')->Required(),
            Item::Add('slug')->Title(function () {
                if (env('BYTE_SUB_DOMAIN')) {
                    return 'Subdomain';
                }
                return 'Slug';
            })->When(function ($item, $manager) {
                return $manager->IsTable();
            })->DisableEdit()->DataText(function ($item) {
                $button = $item->ConvertToButton()
                    ->Title(function ($button) {
                        $item = $button->getData();
                        return route('page-builder.slug', ['slug' => $item->slug]);
                    })
                    ->ButtonType(function ($button) {
                        $item = $button->getData();
                        return 'link';
                    })->Target('_blank');
                if ($button->getWhen()) {
                    $button->ButtonLink(function ($button) {
                        $item = $button->getData();
                        return  route('page-builder.slug', ['slug' => $item->slug]);
                    });
                }
                return $button->render();
            }),
            Item::Add('content')->Title('content')->Type('tinymce')->Column(Item::Col12)->Required()->When(function ($item, $manager) {
                return !$manager->IsTable();
            }),
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
        ];
    }

    public function TablePage()
    {
        return ItemManager::Table()
            ->Model($this->GetModel())
            ->BeforeQuery(function ($query) {
                if (checkPermission('admin.use_only_author')) {
                    $query->where('author_id', auth()->user()->id);
                }
                return $query->with('seo');
            })
            // ->EditInTable()
            ->Title('Page Manager')
            ->Filter()
            ->Sort()
            ->CheckBoxRow()

            ->ButtonOnPage(function () {
                return [
                    Button::Create("Create Page")->ButtonType(function () {
                        return 'primary';
                    })->ButtonLink(function () {
                        return route('admin.page-builder-new');
                    })
                ];
            })
            ->ButtonInTable(function () {
                return [
                    Button::Create("Edit")->ButtonType(function () {
                        return 'info';
                    })->ButtonLink(function ($button) {
                        return route('admin.page-builder-edit', ['dataId' => $button->getData()->id]);
                    }),
                    Button::Create("Remove")->ButtonType(function () {
                        return 'warning';
                    })->ConfirmTitle("Remove Page")->Confirm("Sure you wanna delete?")->WireClick(function ($button) {
                        $item = $button->getData();
                        return "callDoAction('deleteRow',{'id':" . $item->id . "})";
                    }),
                ];
            })
            ->Item($this->GetFields())
            ->Action('changeStatus', function ($params, $compoent) {
                ['id' => $id, 'status' => $status] = $params;
                ($this->GetModel())::where('id', $id)->update(['status' => $status]);
            })->Action('deleteRow', function ($params, $compoent) {
                ['id' => $id] = $params;
                ($this->GetModel())::where('id', $id)->delete();
                $compoent->showMessage("Delete record successfully.");
            });
    }
    public function FormPage()
    {
        return ItemManager::Form()
            ->Model($this->GetModel())
            ->BeforeSave(function ($model) {
                $model->author_id = auth()->user()->id;
                return $model;
            })
            ->Title('Page Form')
            ->Message(function ($manager) {
                if ($manager->getData()->getDataId() > 0) {
                    return 'Update Page success';
                }
                return 'Create Page success';
            })
            ->Item($this->GetFields());
    }
    public function SetupFormCustom()
    {
        // $this->FormCustom('permission', function () {
        //     return ItemManager::Form()
        //         ->Model($this->GetModel())->Item([
        //             Item::Add('name')->Title('Name')->Column(Item::Col12)->Type('readonly'),
        //             Item::Add('PermissionIds')->Title('Permissions')->Column(Item::Col12)->Type('toggle-multiple')->DataOption(function () {
        //                 return \BytePlatform\Models\Permission::all()->map(function ($item) {
        //                     return [
        //                         'value' => $item->id,
        //                         'text' => $item->name
        //                     ];
        //                 });
        //             })
        //         ])->FormDoSave(function ($params, $component, $manager) {
        //             $role = Role::find($component->dataId);
        //             $role->permissions()->sync(collect($component->form->PermissionIds)->filter(function ($item) {
        //                 return $item > 0;
        //             })->toArray());
        //             $component->showMessage("Update permission of role success");
        //             $component->closeComponent();
        //             $component->refreshRefComponent();
        //         });
        // });
    }
}
