<?php


use Illuminate\Support\Facades\Route;

use yangpimpollo\L3_infrastructure\Controllers\HelloWorldController;




Route::get('/hello', HelloWorldController::class);