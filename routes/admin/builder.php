<?php

use Illuminate\Support\Facades\Route;


Route::post('builder/template-manager', BytePlatform\Builder\Livewire\TemplateManager\Index::class)->name('admin.builder.template-manager');
