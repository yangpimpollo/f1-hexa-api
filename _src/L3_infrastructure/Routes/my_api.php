<?php


use Illuminate\Support\Facades\Route;

use yangpimpollo\L3_infrastructure\Controllers\AuthController;
use yangpimpollo\L3_infrastructure\Controllers\CustomerController;
use yangpimpollo\L3_infrastructure\Controllers\DashBoardController;
use yangpimpollo\L3_infrastructure\Controllers\HelloWorldController;
use yangpimpollo\L3_infrastructure\Controllers\HomeController;
use yangpimpollo\L3_infrastructure\Controllers\SearchController;



Route::get('/hello', HelloWorldController::class);
Route::get('/home', HomeController::class);

Route::get('/auth', [AuthController::class, 'index']);
Route::post('/auth.login', [AuthController::class, 'login']);
Route::post('/auth.logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');


Route::middleware('auth:sanctum')->group(function () {

    Route::get('/dashboard', DashBoardController::class);

    Route::get('/search-customer/{id}', [CustomerController::class, 'show']);
    Route::post('/store-customer', [CustomerController::class, 'store']);

    Route::get('/products/search',[SearchController::class, 'index']);
    
});



// use Illuminate\Http\Request;

// Route::get('/products/search', function (Request $request) {
//     // Obtenemos 'q' desde la URL ?q=petro
//     return $request->query('q'); 
// });
    



use yangpimpollo\L1_domain\ValueObjects\dni;


Route::get('/test-dni/{valor}', function ($valor) {
    $objetoDni = new dni($valor); 
    return response()->json(['dni' => $objetoDni->value()]);
});