<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\todolistController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\UserController;

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
Route::group(['middleware' => 'auth:sanctum'], function(){
    Route::apiResource('member',MemberController::class);
    Route::get('todo', [todolistController::class,'list']);
    Route::get('todo/{id}', [todolistController::class,'index']);
    Route::post('add',[todolistController::class,'add']);
    Route::put('update',[todolistController::class, 'update']);
    Route::delete('delete/{id}',[todolistController::class, 'delete']);
    Route::get('search/{title}',[todolistController::class, 'search']);
    Route::post('save',[todolistController::class,'testData']);
    Route::post('logout',[UserController::class, 'logout']);
    });

Route::get('users',[UserController::class, 'getUsers']);
Route::get('users/{email}',[UserController::class, 'searchEmail']);
Route::get('users/{id}',[UserController::class, 'searchUser']);
Route::post('register',[UserController::class, 'register']);
Route::post('login',[UserController::class, 'login'])->name('login');
