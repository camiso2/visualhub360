<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

// 🚨 NUEVA LÍNEA CRÍTICA: Fallback para Vue Router
// Esta ruta capturará CUALQUIER otra URL (como /users, /dashboard, etc.)
// y devolverá la vista principal ('welcome') para que Vue Router la maneje.
/*Route::get('/{any}', function () {
    return view('welcome');
})->where('any', '.*');*/
// Luego la ruta SPA para Vue (excluye /api)
Route::get('/{any}', function () {
    return view('welcome'); // tu SPA
})->where('any', '.*');
