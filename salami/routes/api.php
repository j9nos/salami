<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\API\SalamiController;
use App\Http\Controllers\API\AuthController;

Route::get("/salamis", [SalamiController::class, "show_salamis"]);
Route::get("/salami/{id}", [SalamiController::class, "show_salami"]);
Route::get("/salami/search-by-name/{name}", [SalamiController::class, "search_salami_by_name"]);
Route::get("/salami/search-by-meat/{meat}", [SalamiController::class, "search_salami_by_meat"]);

Route::post("/register", [AuthController::class, "register"]);
Route::post("/login", [AuthController::class, "login"]);

Route::group(["middleware" => ["auth:sanctum"]], function()
{
    Route::post("/add-salami", [SalamiController::class, "add_new_salami"]);
    Route::put("/edit-salami/{salami}", [SalamiController::class, "edit_salami_data"]);
    Route::delete("/throw-salami/{id}", [SalamiController::class, "throw_salami_out"]);
    Route::post("/logout", [AuthController::class, "logout"]);
}); 
