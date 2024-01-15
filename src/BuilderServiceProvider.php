<?php

namespace Sokeio\Builder;

use Sokeio\Admin\Facades\Menu;
use Sokeio\Platform\DataInfo;
use Illuminate\Support\ServiceProvider;
use Sokeio\Laravel\ServicePackage;
use Sokeio\Concerns\WithServiceProvider;
use Illuminate\Support\Facades\File;

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
            //     menu::route(['name' => 'admin.builder.template', 'params' => []], 'Templates', '<svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-brand-pagekit" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
            //     <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
            //     <path d="M12.077 20h-5.077v-16h11v14h-5.077"></path>
            //  </svg>', [], 'admin.page-builder-list');
            }
        });
    }
}
