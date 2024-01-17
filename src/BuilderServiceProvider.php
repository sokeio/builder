<?php

namespace Sokeio\Builder;

use Sokeio\Admin\Facades\Menu;
use Sokeio\Platform\DataInfo;
use Illuminate\Support\ServiceProvider;
use Sokeio\Laravel\ServicePackage;
use Sokeio\Concerns\WithServiceProvider;
use Illuminate\Support\Facades\File;
use Sokeio\Admin\Menu\MenuBuilder;
use Sokeio\Components\UI;
use Sokeio\Facades\Platform;

class BuilderServiceProvider extends ServiceProvider
{
    use WithServiceProvider;

    public function configurePackage(ServicePackage $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         */
        $package
            ->name('builder')
            ->hasConfigFile()
            ->hasViews()
            ->hasHelpers()
            ->hasAssets()
            ->hasTranslations()
            ->runsMigrations();
    }
    public function extending()
    {
    }
    public function packageRegistered()
    {
        DataInfo::macro('getTemplateBuilder', function () {
            $path = $this->getPath('resources/template-builders');
            if (File::exists($path) && $files =  collect(File::allFiles($path))->map(function ($item) {
                return $item->getPathname();
            })) {
                return $files;
            }
            return [];
        });
        $this->extending();
    }
    private function bootGate()
    {
        if (!$this->app->runningInConsole()) {
            add_filter(PLATFORM_PERMISSION_CUSTOME, function ($prev) {
                return [
                    ...$prev
                ];
            });
        }
    }
    public function packageBooted()
    {
        $this->bootGate();
        Platform::Ready(function () {
            if (sokeio_is_admin()) {
                add_filter('CMS_PAGE_BUTTONS', function ($prev) {
                    return [
                        UI::Button(__('Create With Builder'))->Route('admin.builder.page.new'),
                        ...$prev,
                    ];
                });
                add_filter('CMS_PAGE_TABLE_ACTIONS', function ($prev) {
                    return [
                        UI::Button(__('Edit With Builder'))->Cyan()->Route('admin.builder.page.edit', function ($row) {
                            return ['dataId' => $row->id];
                        }),
                        ...$prev,
                    ];
                });
            }
            add_filter('CMS_POST_BUTTONS', function ($prev) {
                return [
                    UI::Button(__('Create With Builder'))->Route('admin.builder.post.new'),
                    ...$prev,
                ];
            });
            add_filter('CMS_POST_TABLE_ACTIONS', function ($prev) {
                return [
                    UI::Button(__('Edit With Builder'))->Cyan()->Route('admin.builder.post.edit', function ($row) {
                        return ['dataId' => $row->id];
                    }),
                    ...$prev,
                ];
            });
        });
        Menu::Register(function () {
            if (sokeio_is_admin()) {
                Menu::attachMenu('system_setting_menu', function (MenuBuilder $menu) {
                    $menu->route(['name' => 'admin.builder-plugin', 'params' => []], __('Builder Plugin'), '', [], 'admin.builder-plugin');
                });
            }
        });
    }
}
