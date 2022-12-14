<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\MailController;

use Illuminate\Http\Request;

use App\Http\Controllers\FileController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\PlacesController;
use App\Http\Controllers\LikesController;
use App\Http\Controllers\NuevaController;

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

Route::get('/', function (Request $request) {
    $message = 'Loading welcome page';
    Log::info($message);
    $request->session()->flash('info', $message);
    return view('welcome');
 }); 

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

require __DIR__.'/auth.php';

Route::get('mail/test', [MailController::class, 'test'])->middleware(['auth', 'verified']);
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/language/{locale}', [App\Http\Controllers\LanguageController::class, 'language']);

Route::resource('files', FileController::class)
->middleware(['auth', /*'permission:files'*/]);

Route::resource('places', PlacesController::class)
    ->middleware(['auth', 'permission:places']);

Route::resource('post', PostController::class)
    ->middleware(['auth', 'permission:post']);

Route::post('/post/{post}/likes', [App\Http\Controllers\PostController::class, 'likes']);
Route::delete('/post/{post}/likes', [App\Http\Controllers\PostController::class, 'unlikes']);


Route::resource('nueva', NuevaController::class)
    ->middleware(['auth']);

Route::get('/aboutus', function(){
    return view('aboutus');
});

Route::post('/places/{place}/favourites', [App\Http\Controllers\PlacesController::class, 'favourite'])->name('places.favourite');
Route::delete('/places/{place}/favourites', [App\Http\Controllers\PlacesController::class, 'unfavourite'])->name('places.unfavourite');

