<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


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
    return view('site.welcome');
});

Auth::routes(['verify' => true]);

Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard')->middleware('verified');
Route::get('dashboard/categorias', 'App\Http\Controllers\DashboardController@categorias')->name('categorias')->middleware('verified');

Route::resource('transacoes', 'App\Http\Controllers\TransacoesController')->middleware('verified')->parameters([
    'transacoes' => 'transacao' // Define o parâmetro corretamente como 'transacao' pois o laravel automaticamente deixa no singular errado "transaco"
]);


Route::get('/categorias/{tipo}', 'App\Http\Controllers\CategoriaController@getCategoriasPorTipo');

