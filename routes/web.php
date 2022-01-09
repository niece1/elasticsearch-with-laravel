<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SearchController;
use Illuminate\Http\Request;
use App\Models\Customer;

//Frontend
Route::get('/', [HomeController::class, 'index'])->name('index');
Route::get('search', [SearchController::class, 'search'])->name('search');

//available at url localhost/customer/?q=nathen10 (nathen10 is a username column entry)
Route::get('/customer', function (Request $request) {
    $customers = Customer::search($request->q)->get(); //paginate(10) to test pagination or keys() to pluck and return the primary keys of the given results
    dd($customers);
});

Route::get('/single-customer', function (Request $request) {
    Customer::find(3)->delete();
    $customers = Customer::search($request->q)->get();
    dd($customers);
});
