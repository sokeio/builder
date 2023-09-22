<?php

use Illuminate\Support\Facades\Route;

Route::get('{slug}', function ($slug) {
    return $slug;
});
