<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\ArtistController;
use App\Http\Controllers\VenueController;
use App\Http\Controllers\UserTicketController;
use App\Http\Controllers\API\AuthController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::resource('users.tickets', UserTicketController::class)->only(['index']);
Route::resource('tickets', TicketController::class)->only(['index']);
Route::resource('artists', ArtistController::class)->only(['index']);
Route::resource('venues', VenueController::class)->only(['index']);

Route::get('/users/{id}', [UserController::class, 'show'])->name('users.show');
Route::get('/users', [UserController::class, 'index'])->name('users.index');

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);


Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('/profile', function (Request $request) {
        return auth()->user();
    });
    Route::resource('update-tickets', TicketController::class)->only(['update']);
    Route::resource('buy-tickets', TicketController::class)->only(['store']);
    Route::resource('delete-tickets', TicketController::class)->only(['destroy']);

    Route::resource('update-artists', ArtistController::class)->only(['update']);
    Route::resource('buy-artists', ArtistController::class)->only(['store']);
    Route::resource('delete-artists', ArtistController::class)->only(['destroy']);

    Route::resource('update-venues', VenueController::class)->only(['update']);
    Route::resource('buy-venues', VenueController::class)->only(['store']);
    Route::resource('delete-venues', VenueController::class)->only(['destroy']);
    // API route for logout user
    Route::post('/logout', [AuthController::class, 'logout']);
});
