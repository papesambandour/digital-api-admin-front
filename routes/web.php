<?php

use App\Http\Controllers\Api\CommissionController;
use App\Http\Controllers\Api\SousServicesController;
use App\Http\Controllers\Api\SousServicesPartnersController;
use App\Http\Controllers\Api\SousServicesPhonesController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClaimController;
use App\Http\Controllers\ConfigurationController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Export\ExcelController;
use App\Http\Controllers\Export\PdfController;
use App\Http\Controllers\PartnersController;
use App\Http\Controllers\PhonesController;
use App\Http\Controllers\TransactionsController;
use App\Http\Controllers\UsersController;
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
    Route::get('/403',[AuthController::class,'unAuthorized'] );
});


Route::group(['middleware'=>['backoffice-auth']],function(){
    /*REPORTING START*/
    Route::get('/',[DashboardController::class,'dashboard'] );
    Route::get('/statistic',[DashboardController::class,'statistic'] );
    /*REPORTING START*/

    /*TRANSACTION START*/
    Route::get('/transaction/details/{transaction}',[TransactionsController::class,'details'] );
    Route::get('/transaction/export-virement-bank',[TransactionsController::class,'exportVirementBank'] );
    Route::put('/transaction/import-virement-bank',[TransactionsController::class,'importVirementBank'] );
    Route::post('/transaction/refund/{transaction}',[TransactionsController::class,'reFund'] );
    Route::post('/transaction/success/{transaction}',[TransactionsController::class,'setSuccessTransaction'] );
    Route::post('/transaction/failed/{transaction}',[TransactionsController::class,'setFailTransaction'] );
    Route::get('/transaction',[TransactionsController::class,'transaction'] );

    Route::get('/versement',[TransactionsController::class,'versement'] );
    Route::get('/mvm-compte',[TransactionsController::class,'mvmCompte'] );
    Route::get('/versement-phones',[TransactionsController::class,'versementPhones'] );
    Route::get('/mvm-compte-phones',[TransactionsController::class,'mvmComptePhones'] );
    /*TRANSACTION END*/

    /*CONFIGURATIONS START*/
    Route::get('/sous-service/toggle/{id}',[ConfigurationController::class,'toggleService'] );
    Route::get('/sous-service',[ConfigurationController::class,'serviceSous'] );
//    Route::get('/apikey',[ConfigurationController::class,'apikey'] );
//    Route::post('/apikey/addkey',[ConfigurationController::class,'addKey'] );
//    Route::post('/apikey/regenerateKey/{idKey}',[ConfigurationController::class,'regenerateKey'] );
    Route::get('/reclamation',[ConfigurationController::class,'reclamation'] );
    /*CONFIGURATIONS END*/

    /*PARTNERS END*/
    Route::get('/partners/versement/{id}',[PartnersController::class ,'versement']);
    Route::post('/partners/versement/{id}',[PartnersController::class ,'versementSave']);
    Route::get('/partners/callFund/{id}',[PartnersController::class ,'callFund']);
    Route::post('/partners/callFund/{id}',[PartnersController::class ,'callFundSave']);
    Route::resource('/partners',PartnersController::class );
    /*PARTNERS END*/
    /*PARTNERS END*/
    Route::get('/phones/verser/{id}',[PhonesController::class ,'versement']);
    Route::post('/phones/verser/{id}',[PhonesController::class ,'versementSave']);
    Route::get('/phones/callFund/{id}',[PhonesController::class ,'callFund']);
    Route::post('/phones/callFund/{id}',[PhonesController::class ,'callFundSave']);
    Route::resource('/phones', PhonesController::class );
    /*PARTNERS END*/

    /*CLAIM START*/
    Route::resource('/claim', ClaimController::class)->only(['index','show','edit','update']);
    /*CLAIM END*/
    /*USER START*/
    Route::resource('/users', UsersController::class)->except(['delete'])->middleware('admin');
    Route::get('/profil', [UsersController::class,'profil']);
    Route::post('/account', [UsersController::class,'account']);
    Route::post('/password', [UsersController::class,'password']);
    /*USER END*/

    Route::get('/storage/{path}',function (string $path ){
        return readFileHelper($path);
    });
});


Route::group(['middleware'=>['backoffice-auth'],'prefix'=>'api'],function(){
    Route::resource('sous_services', SousServicesController::class)->except([
        'create'
    ]);
    Route::resource('sous_services_partners', SousServicesPartnersController::class)->except([
        'create'
    ]);
    Route::resource('sous_services_phones', SousServicesPhonesController::class)->except([
        'create'
    ]);
    Route::resource('commission', CommissionController::class)->except([
        'create'
    ]);
});

Route::group(['prefix'=>'api/export','middleware'=>['jwt.verify','jwt.pwd-change']],function () {
        Route::post('/excel', [ExcelController::class,'exportGeneric']);
         Route::post('/pdf', [PdfController::class,'export']);
});
