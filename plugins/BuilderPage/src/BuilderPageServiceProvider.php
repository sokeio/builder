<?php

namespace SokeioPlugin\BuilderPage;

use Sokeio\Admin\Facades\Menu;
use Sokeio\Admin\Facades\SettingForm;
use Sokeio\Admin\ItemManager;
use Sokeio\Item;
use Illuminate\Support\ServiceProvider;
use Sokeio\Laravel\ServicePackage;
use Sokeio\Concerns\WithServiceProvider;
use Sokeio\Seo\Facades\Sitemap;
use SokeioPlugin\BuilderPage\Models\PageBuilder;
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

                            $data = PageBuilder::query()->where('slug', $slug)->first();
                            if ($data && $data->status) {
                                // if ($data->id == setting('page_homepage_id')) {
                                //     return redirect('/');
                                // }
                                page_title($data->name, true);
                                return view('builderpage::homepage', [
                                    'content' => pagebuilder_render($data),
                                ]);
                            }
                            return abort(404);
                        })->name('page-builder.slug');
                    });
                } else {
                    Route::get('/{slug}', function ($slug) {
                        $data = PageBuilder::query()->where('slug', $slug)->first();
                        if ($data && $data->status) {
                            if ($data->id == setting('page_homepage_id')) {
                                return redirect('/');
                            }
                            page_title($data->name, true);
                            return view('builderpage::homepage', [
                                'content' => pagebuilder_render($data),
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
                    'admin.use_only_author',
                    ...$prev
                ];
            });
        }
        add_filter(PLATFORM_HOMEPAGE, function () {
            $data = PageBuilder::query()->where('id', setting('page_homepage_id'))->first();
            if ($data) {
                page_title($data->name, true);
                return  [
                    'view' => 'builderpage::homepage',
                    'params' => [
                        'content' => pagebuilder_render($data),
                    ]
                ];
            }
            return [
                'view' => 'builderpage::homepage',
                'params' => [
                    'content' => "<div>HomePage is not setting</div>",
                ]
            ];
        });
        add_action('SEO_SITEMAP_INDEX', function () {
            Sitemap::addSitemap(route('sitemap_type', ['sitemap' => 'page-builder']));
        });
        add_action('SEO_SITEMAP_PAGE-BUILDER', function () {
            Sitemap::addSitemap(route('sitemap_page', ['sitemap' => 'page-builder', 'page' => 1]));
        });
        add_action('SEO_SITEMAP_PAGE_PAGE-BUILDER', function ($page) {
            foreach (PageBuilder::all() as $item) {
                Sitemap::addItem($item->getUrl());
            }
        });
        SettingForm::Register(function (ItemManager $form) {
            $form->Item([
                Item::Add('page_homepage_id')->Type('select')->Column(Item::Col12)->Title('Homepage')->Attribute(function () {
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
