<?php

use App\Http\Controllers\Auth\Login;
use App\Http\Controllers\Auth\Logout;
use App\Http\Controllers\Auth\Register;
use App\Http\Controllers\Auth\RequestResetPassword;
use App\Http\Controllers\ChirpController;
use App\Http\Controllers\Profile\Account;
use App\Http\Controllers\ResetPasswordController;
use Illuminate\Support\Facades\Route;

Route::get("/", [ChirpController::class, "index"]);

// Protected routes
Route::middleware("auth")->group(function () {
    Route::post("/chirps", [ChirpController::class, "store"]);
    Route::get("/chirps/{chirp}/edit", [ChirpController::class, "edit"]);
    Route::put("/chirps/{chirp}", [ChirpController::class, "update"]);
    Route::delete("/chirps/{chirp}", [ChirpController::class, "destroy"]);
});

// Registration routes
// 2th arguments is the name of the view
Route::view("/register", "auth.register")
    ->middleware("guest")
    ->name("register");

Route::post("/register", Register::class)->middleware("guest");

Route::view("/login", "auth.login")->middleware("guest")->name("login");
Route::post("/login", Login::class)->middleware("guest");

Route::post("/logout", Logout::class)->middleware("auth")->name("logout");

Route::middleware("auth")->group(function () {
    Route::get("/profile", Account::class);

    Route::post("/request-reset-password", RequestResetPassword::class);

    Route::get("/reset-password/{token}", [
        ResetPasswordController::class,
        "edit",
    ])->name("password.reset");

    Route::post("reset-password", [
        ResetPasswordController::class,
        "update",
    ])->name("password.update");
});
