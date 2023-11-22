<?php

use Sokeio\Builder\Crud\TemplateCategoryCurd;
use Illuminate\Support\Facades\Route;


Route::post('builder/template-manager', Sokeio\Builder\Livewire\TemplateManager\Index::class)->name('admin.builder.template-manager');
Route::get('builder/template', Sokeio\Builder\Livewire\Template\Index::class)->name('admin.builder.template');
Route::get('builder/template/create', Sokeio\Builder\Livewire\Template\Builder::class)->name('admin.builder.template-create');
Route::get('builder/template/{?id}', Sokeio\Builder\Livewire\Template\Builder::class)->name('admin.builder.template-edit');
TemplateCategoryCurd::RoutePage('template-category');
