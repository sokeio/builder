<?php

use BytePlugin\BuilderPage\Crud\PageCrud;
use BytePlugin\BuilderPage\Livewire\PageBuilder;
use Illuminate\Support\Facades\Route;

Route::group(['as' => 'admin.'], function () {
    PageCrud::RoutePage('page-builder');
    Route::get('page-builder/edit/{dataId}', route_theme(PageBuilder::class))->name('page-builder-edit');
    Route::get('page-builder/new', route_theme(PageBuilder::class))->name('page-builder-new');
});
