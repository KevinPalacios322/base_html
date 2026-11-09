<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PersonaController;
Route::get('/', function () {
return redirect()->route('login');
});
Route::get('/login', [LoginController::class, 'create'])
->name('login');
Route::post('/login', [LoginController::class, 'store'])
->middleware('throttle:6,1')->name('login.store');
Route::middleware('auth')->group(function () {
Route::get('/inicio', function () {
return redirect()->route('personas.index');
})->name('inicio');
Route::get('/personas', [PersonaController::class, 'index'])
->name('personas.index');
Route::post('/logout', [LoginController::class, 'destroy'])
->name('logout');
});