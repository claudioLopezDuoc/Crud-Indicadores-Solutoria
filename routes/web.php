<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AjaxController;

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
    return view('welcome');
});


Route::get('ajax/datos',[AjaxController::class,'getDatos'])
->name('ajax/datos')
;
Route::resource('ajax', AjaxController::class);

Route::get('ajax/store',[AjaxController::class,'store'])
->name('ajax/store');

/*Route::get('ajax/grafico',[ChartController::class,'index'])
->name('ajax/grafico');*/