<?php

use BytePlatform\Builder\Crud\TemplateCategoryCurd;
use Illuminate\Support\Facades\Route;


Route::post('builder/template-manager', BytePlatform\Builder\Livewire\TemplateManager\Index::class)->name('admin.builder.template-manager');
Route::get('builder/template', BytePlatform\Builder\Livewire\Template\Index::class)->name('admin.builder.template');
Route::get('builder/template/create', BytePlatform\Builder\Livewire\Template\Builder::class)->name('admin.builder.template-create');
Route::get('builder/template/{?id}', BytePlatform\Builder\Livewire\Template\Builder::class)->name('admin.builder.template-edit');
TemplateCategoryCurd::RoutePage('template-category');
