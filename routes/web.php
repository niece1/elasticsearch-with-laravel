<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\TrashController;
use App\Http\Controllers\SubscriptionController;
use Illuminate\Http\Request;
use App\Models\Customer;

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

//Frontend
Route::get('/', [HomeController::class, 'index'])->name('index');
Route::get('search', [SearchController::class, 'search'])->name('search');
Route::post('subscriptions', SubscriptionController::class);

//Admin
Route::group(['prefix' => 'admin'], function () {
    Route::resource('posts', PostController::class);
    //Expunge Image
    Route::get('delete/{id}', [ImageController::class, 'delete'])->name('image.delete');
    //Trash
    Route::get('trash', [TrashController::class, 'index'])->name('trash.index');
    Route::delete('delete/{id}', [TrashController::class, 'destroy'])->name('trash.destroy');
    Route::post('restore/{id}', [TrashController::class, 'restore'])->name('trash.restore');
});

Route::get('/customer', function (Request $request) {
    $customers = Customer::search($request->q)->get();
    dd($customers);
});

Route::get('/single-customer', function (Request $request) {
    Customer::find(3)->delete();
    $customers = Customer::search($request->q)->get();
    dd($customers);
});
