<?php

use App\Http\Controllers\AttendingEventController;
use App\Http\Controllers\DeleteCommentController;
use App\Http\Controllers\EventAttendingController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\EventIndexController;
use App\Http\Controllers\EventSaveController;
use App\Http\Controllers\EventShowController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\GalleryIndexController;
use App\Http\Controllers\LikeEventController;
use App\Http\Controllers\LikeSystemController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SaveEventController;
use App\Http\Controllers\StoreCommentController;
use App\Http\Controllers\WelcomeController;
use App\Models\Country;
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

Route::get('/', WelcomeController::class)->name('welcome');
Route::get('/e/{id}', EventShowController::class)->name('eventShow');
Route::get('/e', EventIndexController::class)->name('eventIndex');
Route::get('/gallery', GalleryIndexController::class)->name('galleryIndex');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    Route::get('/liked-events',LikeEventController::class)->name('likedEvents');
    Route::get('/saved-events',SaveEventController::class)->name('savedEvents');
    Route::get('/attending-events',AttendingEventController::class)->name('attendingEvents');
    
    Route::resource('/events', EventController::class);
    Route::resource('/galleries', GalleryController::class);
    Route::post('/events-like/{id}', LikeSystemController::class)->name('events.like');
    Route::post('/events-saved/{id}', EventSaveController::class)->name('events.save');
    Route::post('/events-attending/{id}', EventAttendingController::class)->name('events.attending');
    
    Route::post('/events/{id}/comments', StoreCommentController::class)->name('events.comments');
    Route::delete('/events/{id}/comments{comment}', DeleteCommentController::class)->name('events.comments.destroy');
    
    Route::get('/countries/{country}', function (Country $country) {
        return response()->json($country->cities);
    });
});

require __DIR__.'/auth.php';
