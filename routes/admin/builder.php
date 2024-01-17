<?php

use Illuminate\Support\Facades\Route;
use Sokeio\Builder\Livewire\BuilderPlugin\BuilderPluginForm;
use Sokeio\Builder\Livewire\BuilderPlugin\BuilderPluginTable;
use Sokeio\Builder\Livewire\PageBuilder;

Route::group([
    'as' => 'admin.',
], function () {
    Route::get('builder/create-page', PageBuilder::class);
    route_crud('builder-plugin', BuilderPluginTable::class, BuilderPluginForm::class);
});
