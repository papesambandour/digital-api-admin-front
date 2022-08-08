<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ConfigurationController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PartnersController;
use App\Http\Controllers\TransactionsController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\URL;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
$proxy_url    = getenv('PROXY_URL');
$proxy_schema = getenv('PROXY_SCHEMA');

if (!empty($proxy_url)) {
    URL::forceRootUrl($proxy_url);
}

if (!empty($proxy_schema)) {
    URL::forceScheme($proxy_schema);
}


Route::group(['middleware'=>[],'prefix'=>'auth'],function(){
    Route::get('/login',[AuthController::class,'login'] );
    Route::post('/login',[AuthController::class,'loginPost'] );
    Route::get('/logout',[AuthController::class,'logOut'] );
});


Route::group(['middleware'=>['admin-auth']],function(){
    /*REPORTING START*/
    Route::get('/',[DashboardController::class,'dashboard'] );
    Route::get('/statistic',[DashboardController::class,'statistic'] );
    /*REPORTING START*/

    /*TRANSACTION START*/
    Route::get('/transaction',[TransactionsController::class,'transaction'] );
    Route::get('/versement',[TransactionsController::class,'versement'] );
    Route::get('/mvm-compte',[TransactionsController::class,'mvmCompte'] );
    /*TRANSACTION END*/

    /*CONFIGURATIONS START*/
    Route::get('/service',[ConfigurationController::class,'service'] );
//    Route::get('/apikey',[ConfigurationController::class,'apikey'] );
//    Route::post('/apikey/addkey',[ConfigurationController::class,'addKey'] );
//    Route::post('/apikey/regenerateKey/{idKey}',[ConfigurationController::class,'regenerateKey'] );
    Route::get('/reclamation',[ConfigurationController::class,'reclamation'] );
    /*CONFIGURATIONS END*/

    /*PARTNERS END*/
    Route::get('/partners',[PartnersController::class,'index'] );
    /*PARTNERS END*/
});
