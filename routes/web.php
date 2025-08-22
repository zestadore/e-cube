<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::middleware(['auth'])->group(function () {
    Route::get('/select-option', [App\Http\Controllers\HomeController::class, 'chooseType'])->name('chooseType');
    Route::get('/register-as-job-seeker', [App\Http\Controllers\HomeController::class, 'registerAsJobSeeker'])->name('jobseeker.register');
    Route::get('/register-as-employer', [App\Http\Controllers\HomeController::class, 'registerAsEmployer'])->name('recruiter.register');
});

