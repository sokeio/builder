<?php

namespace Sokeio\Builder;

use Sokeio\Admin\Facades\Menu;
use Sokeio\Platform\DataInfo;
use Illuminate\Support\ServiceProvider;
use Sokeio\Laravel\ServicePackage;
use Sokeio\Concerns\WithServiceProvider;
use Illuminate\Support\Facades\File;
use Sokeio\Admin\Menu\MenuBuilder;

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
            if (File::exists($this->getPath('resources/template-builders')) && $files =  collect(File::allFiles($this->getPath('resources/template-builders')))->map(function ($item) {
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
        Menu::Register(function () {
            if (sokeio_is_admin()) {
                Menu::attachMenu('system_setting_menu', function (MenuBuilder $menu) {
                    $menu->route(['name' => 'admin.builder-plugin', 'params' => []], __('Builder Plugin'), '', [], 'admin.builder-plugin');
                });
            }
        });
    }
}
