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
    }
    private function bootGate()
    {
        if (!$this->app->runningInConsole()) {
            addFilter(PLATFORM_PERMISSION_CUSTOME, function ($prev) {
                return [
                    ...$prev
                ];
            });
        }
    }
    public function packageBooted()
    {
        $this->bootGate();
        Platform::ready(function () {
            if (sokeioIsAdmin()) {
                Menu::Register(function () {
                    menuAdmin()->subMenu(__('EZBuilder'), '', function (MenuBuilder $menu) {
                        $menu->route(
                            ['name' => 'admin.builder-template', 'params' => []],
                            __('Template Builder'),
                            '',
                            [],
                            'admin.builder-template'
                        );
                        $menu->route(
                            ['name' => 'admin.builder-plugin', 'params' => []],
                            __('Plugin Settings'),
                            '',
                            [],
                            'admin.builder-plugin'
                        );
                        $menu->route(
                            ['name' => 'admin.builder.template-view', 'params' => []],
                            __('Template Viewer'),
                            '',
                            [],
                            'admin.builder.template-view'
                        );
                    }, 1000);
                });
            }
        });
    }
}
