<?php

namespace BytePlugin\BuilderPage;

use BytePlatform\Facades\Assets;
use BytePlatform\Facades\Menu;
use BytePlatform\Facades\SettingForm;
use BytePlatform\Facades\Shortcode;
use BytePlatform\Item;
use Illuminate\Support\ServiceProvider;
use BytePlatform\Laravel\ServicePackage;
use BytePlatform\Concerns\WithServiceProvider;
use BytePlugin\BuilderPage\Models\PageBuilder;
use Illuminate\Support\Facades\Route;

class BuilderPageServiceProvider extends ServiceProvider
{
    use WithServiceProvider;

    public function configurePackage(ServicePackage $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         */
        $package
            ->name('builderpage')
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
        $this->app->booted(function () {
            Route::group(['middleware' => 'web'], function () {
                if ($subdomain = env('BYTE_SUB_DOMAIN')) {
                    Route::group(['domain' => '{slug}.' . $subdomain], function () {
                        Route::get('/', function ($slug) {
                            Shortcode::enable();
                            Assets::Theme('tabler');
                            Assets::AddCss('https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css');

                            $data = PageBuilder::query()->where('slug', $slug)->first();
                            if ($data && $data->status) {
                                // if ($data->id == setting('page_homepage_id')) {
                                //     return redirect('/');
                                // }
                                do_action('BYTE_BUILDER_SLUG', $data);
                                page_title($data->name, true);
                                Assets::AddScript($data->js);
                                Assets::AddStyle(trim($data->css));

                                return view('builderpage::homepage', [
                                    'content' => $data->content,
                                ]);
                            }
                            return abort(404);
                        })->name('page-builder.slug');
                    });
                } else {
                    Route::get('/{slug}', function ($slug) {
                        Shortcode::enable();
                        Assets::Theme('tabler');
                        Assets::AddCss('https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css');
                        $data = PageBuilder::query()->where('slug', $slug)->first();
                        if ($data && $data->status) {
                            if ($data->id == setting('page_homepage_id')) {
                                return redirect('/');
                            }
                            do_action('BYTE_BUILDER_SLUG', $data);
                            page_title($data->name, true);
                            Assets::AddScript($data->js);
                            Assets::AddStyle(trim($data->css));

                            return view('builderpage::homepage', [
                                'content' => $data->content,
                            ]);
                        }
                        return abort(404);
                    })->name('page-builder.slug');
                }
            });
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
        add_filter(PLATFORM_HOMEPAGE, function () {
            Shortcode::enable();
            Assets::Theme('tabler');
            Assets::AddCss('https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css');
            $data = PageBuilder::query()->where('id', setting('page_homepage_id'))->first();
            if ($data) {
                do_action('BYTE_BUILDER_SLUG', $data);
                Assets::AddScript($data->js);
                Assets::AddStyle(trim($data->css));
                page_title(setting('page_site_title'), true);
                return [
                    'view' => 'builderpage::homepage',
                    'params' => [
                        'content' => $data->content,
                    ]
                ];
            }
            return [
                'view' => 'builderpage::homepage',
                'params' => [
                    'content' => "<div class='p-4'>HomePage is not setting</div>",
                ]
            ];
        });
        SettingForm::Register(function (\BytePlatform\ItemManager $form) {
            $form->Item([
                Item::Add('page_homepage_id')->Type('select')->Title('Homepage')->Attribute(function () {
                    return 'style="max-width:200px;"';
                })->DataOption(function () {
                    return  PageBuilder::query()->get()->map(function ($item) {
                        return  [
                            'value' => $item->id,
                            'text' => $item->name
                        ];
                    })->toArray();
                }),

            ]);
            return $form;
        });
        Menu::Register(function () {
            if (byte_is_admin()) {
                menu::route(['name' => 'admin.page-builder-list', 'params' => []], 'Pages', '<svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-brand-pagekit" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                <path d="M12.077 20h-5.077v-16h11v14h-5.077"></path>
             </svg>', [], 'admin.page-builder-list');
            }
        });
    }
    public function packageBooted()
    {
        $this->bootGate();
        
    }
}
