<?php

use Illuminate\Support\Facades\Route;
use App\Events\OrderStatusChangedEvent;
use App\Http\Controllers\ChatController;

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

Route::get('/fire', function () {
    $mensaje = "Hola edwing ".date('H:i:s');
    event (new OrderStatusChangedEvent($mensaje));
    return 'evento ejecutado';
});

Route::get('/chat', [App\Http\Controllers\ChatController::class, 'index']);
Route::get('/messages', [App\Http\Controllers\ChatController::class, 'fetchMessages']);
Route::post('/message', [App\Http\Controllers\ChatController::class, 'sendMessage']);

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
