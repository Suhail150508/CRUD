<?php

use App\Http\Controllers\StudentController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
// header("Access-Control-Allow-Origin", "*");
// header("Access-Control-Allow-Credentials", "true");
// header("Access-Control-Max-Age", "1800");
// header("Access-Control-Allow-Headers", "content-type");
// header("Access-Control-Allow-Methods", "PUT, POST, GET, DELETE, PATCH, OPTIONS");

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods:POST, GET, OPTION, PUT, DELETE');
header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Auth-Token, Origin, X-Requested-With");



Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/students',[StudentController::class,'index']);
Route::post('/store',[StudentController::class,'store']);
Route::get('/student/{id}/edit',[StudentController::class,'indexid']);
Route::put('/student/{id}/edit',[StudentController::class,'update']);
Route::delete('/student/{id}/delete',[StudentController::class,'delete']);

