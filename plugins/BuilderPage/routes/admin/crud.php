<?php

use BytePlugin\BuilderPage\Crud\PageCrud;
use Illuminate\Support\Facades\Route;

Route::group(['as' => 'admin.'], function () {
    PageCrud::RoutePage('page-builder');
});