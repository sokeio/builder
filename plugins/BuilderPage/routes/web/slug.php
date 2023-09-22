<?php

use Illuminate\Support\Facades\Route;

Route::get('/p/{slug}', function ($slug) {
    return $slug;
});
