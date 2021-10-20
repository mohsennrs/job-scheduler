<?php

use App\Http\Controllers\JobController;
use App\Http\Controllers\LoginController;
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
    return view('welcome');
});

Route::get('/home', function () {
    return 'true';
});


Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/jobs', [JobController::class, 'index']);
Route::prefix('schedules')->group(function () {
    Route::get('/', [App\Http\Controllers\ScheduleController::class, 'index']);

    Route::post('create', [App\Http\Controllers\ScheduleController::class, 'create'])->middleware(['auth:sanctum', 'role:worker']);
    Route::post('edit/{schedule}', [App\Http\Controllers\ScheduleController::class, 'update'])->middleware(['auth:sanctum', 'role:admin']);
});
