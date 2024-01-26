<?php

namespace Sokeio\Builder;

use Illuminate\Support\Facades\File;
use Illuminate\Support\ServiceProvider;
use Sokeio\Laravel\ServicePackage;
use Sokeio\Concerns\WithServiceProvider;
use Sokeio\Facades\Menu;
use Sokeio\Facades\Platform;
use Sokeio\Platform\DataInfo;
use Sokeio\Menu\MenuBuilder;
use Sokeio\Components\UI;

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
                menu_admin()->subMenu(__('Builder Manager'), '', function (MenuBuilder $menu) {
                    $menu->route(['name' => 'admin.builder-template', 'params' => []], __('Template'), '', [], 'admin.builder-template');
                    $menu->route(['name' => 'admin.builder-plugin', 'params' => []], __('Plugin'), '', [], 'admin.builder-plugin');
                }, 1000);
            }
        });
    }
}
