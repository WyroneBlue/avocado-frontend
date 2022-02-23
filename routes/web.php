<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\PageController;

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

// Route::get('/', function () {
//     return Inertia::render('Welcome', [
//         'canLogin' => Route::has('login'),
//         'canRegister' => Route::has('register'),
//         'laravelVersion' => Application::VERSION,
//         'phpVersion' => PHP_VERSION,
//     ]);
// });
Route::get('/', function () {
    return redirect(route('db.films.index'));
});


Route::group(['prefix' => 'dashboard', 'middleware' => ['auth', 'verified']], function(){

    Route::get('/', [PageController::class, 'index'])->name('db.films.index');
    Route::get('/film/{id}', [PageController::class, 'show'])->name('db.films.details');
});

require __DIR__.'/auth.php';
