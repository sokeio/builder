<?php

use Illuminate\Support\Facades\Route;
use Sokeio\Builder\Livewire\PageBuilder;

Route::group([
    'as' => 'admin.',
], function () {
    Route::get('builder/new-page', PageBuilder::class);
});
