<?php

use App\Http\Controllers\Api\User\UserController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\ProductController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});



Route::middleware("auth:sanctum")->group(function () {
    Route::controller(ProductController::class)->group(function () {
        Route::get("/product/list", 'index');
        Route::post("/product/create", "store");
    });

    Route::group(["prefix" => "user"], function () {
        Route::post("/register", [UserController::class, "register"]);
        Route::get("/read", [UserController::class, "read"]);
        Route::get("/user", [UserController::class, "get"]);
        Route::put("/update", [UserController::class, "update"]);
        Route::delete("/delete", [UserController::class, "delete"]);
        Route::post("/updateImage", [UserController::class, "updateImage"]);
    });

    Route::post('/logout', [AuthController::class, 'Logout']);
    Route::post('/auth/check', [AuthController::class, 'Check']);
});


Route::prefix('auth')->group(function () {
    Route::post('/login', [AuthController::class, 'Login']);
    Route::post('/register', [AuthController::class, 'Register']);
});
