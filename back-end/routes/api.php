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


Route::group(['middleware' => 'auth:sanctum'], function() {
    
    Route::get('artists/list', [ArtistController::class, 'list']);
    
    Route::get('artists/{id}', [ArtistController::class, 'view']);
    
    Route::get('albums/list', [AlbumController::class, 'list']);
    
    Route::get('albums/{id}', [AlbumController::class, 'view']);
   
    Route::post('albums/add', [AlbumController::class, 'add']);
    
    Route::put('albums/edit/{id}', [AlbumController::class, 'edit']);
    
    Route::delete('albums/delete/{id}', [AlbumController::class, 'delete']);
    
  
});
