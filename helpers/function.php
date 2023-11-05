<?php

use BytePlatform\Facades\Assets;
use BytePlatform\Facades\Shortcode;
use BytePlatform\Seo\Facades\SEO;
use BytePlatform\Seo\SchemaCollection;
use BytePlatform\Seo\Schemas\ArticleSchema;
use BytePlatform\Seo\Schemas\BreadcrumbListSchema;
use BytePlatform\Seo\SEOData;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

if (!function_exists('pagebuilder_render')) {
    function pagebuilder_render(Model $data)
    {
        Shortcode::enable();
        Assets::Theme('tabler');
        Assets::AddCss('https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css');
        do_action('BYTE_BUILDER_SLUG', $data);
        Assets::AddScript($data->js);
        Assets::AddStyle(trim($data->css));
        Assets::AddScript($data->custom_js);
        Assets::AddStyle(trim($data->custom_css));
        SEO::SEODataTransformer(function (SEOData $dataSeo) use ($data) {
            $dataSeo->title = page_title();
            $dataSeo->description = $data->ddescriptione;
            $dataSeo->image = $data->image ? url($data->image) : null;
            $dataSeo->datePublished = $data->published_at;
            $dataSeo->dateModified = $data->updated_at;
            if ($seo = $data->seo->first()) {
                $seo->fillForSeo($dataSeo);
            }
            $dataSeo->schema = SchemaCollection::initialize()->addArticle(function (ArticleSchema $articleSchema) use ($data) {
            })->addBreadcrumbs(function (BreadcrumbListSchema $breadcrumbListSchema) {
                $breadcrumbListSchema->appendBreadcrumbs([]);
            });
            return $dataSeo;
        });
        return $data->content;
    }
}
