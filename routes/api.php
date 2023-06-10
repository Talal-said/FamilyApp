<?php

use App\Http\Controllers\Api\MembersController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::get('/get-tree', [MembersController::class, 'getFamilyTree']);
Route::get('/users/search', [MembersController::class, 'searchForUser']);
Route::post('/get-relation', [MembersController::class, 'getRelation']);
Route::get('/get-profile', [MembersController::class, 'getProfileData']);
