<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();
Route::get('/migrate', function () {
    Artisan::call("migrate");
});

Route::get('/optimize', function () {
    Artisan::call("optimize");
    Artisan::call("cache:clear");
    Artisan::call("config:clear");
    Artisan::call("view:clear");
    Artisan::call("route:clear");
    Artisan::call("config:cache");
});

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::middleware(['auth'])->group(function () {
    Route::get('/select-option', [App\Http\Controllers\HomeController::class, 'chooseType'])->name('chooseType');
    Route::get('/register-as-job-seeker', [App\Http\Controllers\HomeController::class, 'registerAsJobSeeker'])->name('jobseeker.register');
    Route::get('/register-as-employer', [App\Http\Controllers\HomeController::class, 'registerAsEmployer'])->name('recruiter.register');
    Route::resource('basic-details', App\Http\Controllers\Registration\Candidate\BasicDetailsController::class);
    Route::post('candidate-address', [App\Http\Controllers\Registration\Candidate\BasicDetailsController::class, 'saveAddress'])->name('save-candidate-address');
    Route::post('candidate-qualifications', [App\Http\Controllers\Registration\Candidate\BasicDetailsController::class, 'saveQualifications'])->name('save-candidate-qualification');
    Route::post('candidate-skills', [App\Http\Controllers\Registration\Candidate\BasicDetailsController::class, 'saveSkills'])->name('save-candidate-skill');
    Route::post('save-candidate-experience', [App\Http\Controllers\Registration\Candidate\BasicDetailsController::class, 'saveExperience'])->name('save-candidate-experience');
    Route::get('/change-password', [App\Http\Controllers\HomeController::class, 'changePassword'])->name('change.password');
    Route::post('/change-password', [App\Http\Controllers\HomeController::class, 'updatePassword'])->name('update.password');
    Route::get('/profile', [App\Http\Controllers\HomeController::class, 'authUserProfile'])->name('profile');
    Route::post('/update-profile', [App\Http\Controllers\HomeController::class, 'updateProfile'])->name('profile.update');
    Route::group(['as'=>'admin.','prefix' => 'admin'], function () {
        Route::get('/', [App\Http\Controllers\HomeController::class, 'adminDashboard'])->name('dashboard');
        Route::resource('industry', App\Http\Controllers\Admin\IndustryController::class);
        Route::resource('qualification', App\Http\Controllers\Admin\QualificationController::class);
        Route::resource('computer-and-other-skill', App\Http\Controllers\Admin\ComputerAndOtherSkillController::class);
        Route::resource('background-question', App\Http\Controllers\Admin\BackGroundQuestionController::class);
    });
    Route::group(['as'=>'employee.','prefix' => 'employee'], function () {
        Route::get('/', [App\Http\Controllers\HomeController::class, 'employeeDashboard'])->name('dashboard');
        Route::get('background-questions', [App\Http\Controllers\HomeController::class, 'backGroundQuestion'])->name('background-questions');
        Route::post('save-background-question', [App\Http\Controllers\HomeController::class, 'saveBackgroundQuestion'])->name('save-background-question');
    });
});

