<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [App\Http\Controllers\FrontendController::class, 'index'])->name('frontend_index');
Route::get('/about-us', [App\Http\Controllers\FrontendController::class, 'about_us'])->name('about');
Route::get('/faq', [App\Http\Controllers\FrontendController::class, 'faq'])->name('faq');
Route::get('/privacy-policy', [App\Http\Controllers\FrontendController::class, 'privacyPolicy'])->name('privacy-policy');
Route::get('/terms-and-conditions', [App\Http\Controllers\FrontendController::class, 'termsAndConditions'])->name('terms-and-conditions');
Route::get('/refund-policy', [App\Http\Controllers\FrontendController::class, 'refundPolicy'])->name('refund-policy');
Route::get('/contact', [App\Http\Controllers\FrontendController::class, 'contact'])->name('contact');

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
    Route::post('/company-profile', [App\Http\Controllers\Registration\Company\CompanyProfileController::class, 'store'])->name('company.profile.store');
    Route::get('/subscription-packages', [App\Http\Controllers\HomeController::class, 'subscriptionPackages'])->name('subscription.packages');
    
    // Paytm Payment Routes
    Route::post('/paytm/initiate', [App\Http\Controllers\PaytmController::class, 'initiatePayment'])->name('paytm.initiate');
    Route::post('/paytm/callback', [App\Http\Controllers\PaytmController::class, 'handleCallback'])->name('paytm.callback');
    Route::post('/paytm/status', [App\Http\Controllers\PaytmController::class, 'checkStatus'])->name('paytm.status');
    Route::post('/paytm/test', [App\Http\Controllers\PaytmController::class, 'testPayment'])->name('paytm.test');
    Route::group(['as'=>'admin.','prefix' => 'admin'], function () {
        Route::get('/', [App\Http\Controllers\HomeController::class, 'adminDashboard'])->name('dashboard');
        Route::resource('industry', App\Http\Controllers\Admin\IndustryController::class);
        Route::resource('qualification', App\Http\Controllers\Admin\QualificationController::class);
        Route::resource('computer-and-other-skill', App\Http\Controllers\Admin\ComputerAndOtherSkillController::class);
        Route::resource('background-question', App\Http\Controllers\Admin\BackGroundQuestionController::class);
        Route::resource('subscription-packages', App\Http\Controllers\Admin\SubscriptionPackageController::class);
        Route::resource('payment-methods', App\Http\Controllers\Admin\PaymentMethodController::class);
        Route::resource('sliders', App\Http\Controllers\Admin\SliderController::class);
        Route::resource('events', App\Http\Controllers\Admin\EventController::class);
        Route::resource('reviews', App\Http\Controllers\Admin\ReviewController::class);
        Route::resource('users', App\Http\Controllers\Admin\UserController::class);
    });
    Route::group(['as'=>'employee.','prefix' => 'employee', 'middleware' => 'verified'], function () {
        Route::get('/', [App\Http\Controllers\HomeController::class, 'employeeDashboard'])->name('dashboard');
        Route::get('background-questions', [App\Http\Controllers\HomeController::class, 'backGroundQuestion'])->name('background-questions');
        Route::post('save-background-question', [App\Http\Controllers\HomeController::class, 'saveBackgroundQuestion'])->name('save-background-question');
    });
    Route::group(['as'=>'employer.','prefix' => 'employer', 'middleware' => 'verified'], function () {
        Route::get('/', [App\Http\Controllers\HomeController::class, 'employerDashboard'])->name('dashboard');
        Route::get('company-profile', [App\Http\Controllers\Registration\Company\CompanyProfileController::class, 'index'])->name('company_profile');
        Route::get('select-industry', [App\Http\Controllers\Registration\Company\CompanyProfileController::class, 'selectIndustry'])->name('select_industry');
        Route::post('save-industry', [App\Http\Controllers\Registration\Company\CompanyProfileController::class, 'saveIndustry'])->name('save_industry');
        Route::resource('jobs', App\Http\Controllers\JobPostController::class);
        Route::get('find-talent', [App\Http\Controllers\JobPostController::class, 'findTalent'])->name('find-talent');
        Route::get('candidate/{id}', [App\Http\Controllers\JobPostController::class, 'showCandidate'])->name('candidate.show');
    });
    // 1️⃣ Verification notice page
    Route::get('/email/verify', function () {
        return view('auth.verify-email');
    })->name('verification.notice');

    // 2️⃣ Verify email link
    Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
        $request->fulfill();

        return redirect()->route('employee.dashboard'); // or wherever you want
    })->middleware(['signed'])->name('verification.verify');

    // 3️⃣ Resend verification email
    Route::post('/email/verification-notification', function (Request $request) {
        $request->user()->sendEmailVerificationNotification();

        return back()->with('message', 'Verification link sent!');
    })->middleware(['throttle:6,1'])->name('verification.send');
});

