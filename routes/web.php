<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\LoginController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CatUnitController;
use App\Http\Controllers\EmployeController;
use App\Http\Controllers\BranchstoreController;
use App\Http\Controllers\OutcomeController;
use App\Http\Controllers\KasirController;
use App\Http\Controllers\CashierController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\ListOrderController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\QueueInformation;
use App\Http\Controllers\HistoryTransactionsController;
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

Route::get('/', function () {
    if (Auth::user()->role == 'admin') {
        return route('product.index');
     }
     elseif (Auth::user()->role == 'kasir') {
         return route('cashier.index');
     }elseif (Auth::user()->role == 'dapur') {
         return url('listorder');
     }
     else{
         return view('auth.login');
     }
});

Route::group(['middleware' => ['auth:sanctum', 'checkRole:admin']], function(){
    Route::resource('product', ProductController::Class);
    Route::resource('catunit', CatUnitController::Class);
    Route::resource('employe', EmployeController::Class);
    Route::resource('branchstore', BranchStoreController::Class);
    Route::resource('reporttransaction', HistoryTransactionsController::Class);
    Route::resource('reportoutcome', OutcomeController::Class);
    Route::resource('dashboard', DashboardController::Class);
    Route::post('/reporttransaction/create', [HistoryTransactionsController::class, 'create']);

});

Route::group(['middleware' => ['auth:sanctum', 'checkRole:kasir']], function(){
    Route::resource('outcome', OutcomeController::Class);
    Route::resource('cashier', CashierController::Class);
    Route::resource('historytransactions', HistoryTransactionsController::Class);
    Route::get('/queue', [QueueInformation::class, 'index']);
    Route::post('/queue/getData', [QueueInformation::class, 'getData']);

});

Route::group(['middleware' => ['auth:sanctum', 'checkRole:dapur']], function(){
    Route::get('/listorder', [ListOrderController::class, 'index']);
    Route::post('/listorder/update', [ListOrderController::class, 'update']);

});