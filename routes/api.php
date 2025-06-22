<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\RoleController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('/register', [RegisterController::class, 'register']);
Route::post('/login', [LoginController::class, 'login']);

Route::get('/business', 'BusinessController@index')->middleware('role:admin,investor');
Route::get('/investor', 'InvestorController@index')->middleware('role:admin,business');

Route::middleware('auth:api')->group(function () {
     Route::post('/assign-role', [RoleController::class, 'assignRole']);
     Route::post('/update-profile', [RegisterController::class, 'updateProfile']);
     Route::get('/user-details', [RegisterController::class, 'getUserProfile']);
});
