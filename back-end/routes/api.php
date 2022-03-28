<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AlbumController;
use App\Http\Controllers\ArtistController;

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
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
/*Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});*/

Route::group(['middleware' => 'auth:sanctum'], function() {
    // list all artists
    Route::get('artists/list', [ArtistController::class, 'list']);
    // get a artist
    //Route::get('artists/{id}', [ArtistController::class, 'view']);
    // add a new artist
    //Route::post('artists', [ArtistController::class, 'add']);
    // updating a artist
    //Route::put('artists/{id}', [ArtistController::class, 'edit']);
    // delete a artist
    //Route::delete('artists/{id}', [ArtistController::class, 'delete']);
   
    
    // list all albums
    Route::get('albums/list', [AlbumController::class, 'list']);
    // get a album
    Route::get('albums/{id}', [AlbumController::class, 'view']);
    // add a new album
    Route::post('albums/add', [AlbumController::class, 'add']);
    // updating a album
    Route::put('albums/edit/{id}', [AlbumController::class, 'edit']);
    // delete a album
    Route::delete('albums/delete/{id}', [AlbumController::class, 'delete']);
    
   
    /*// add a new user
    Route::post('add', [TaskController::class, 'addUser']);
    // add a new user
    Route::post('add_admin', [TaskController::class, 'addAdmin']);
    // updating a user
    //Route::put('edit/{id}', [TaskController::class, 'updateUser']);
    // delete a user
    
    Route::delete('users/{id}', [TaskController::class, 'deleteUser']);
    */
});
