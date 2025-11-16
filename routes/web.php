<?php

use App\Http\Controllers\admin\dashboardController;
use App\Http\Controllers\admin\Master\GoalController;
use App\Http\Controllers\admin\Master\SkillController;
use App\Http\Controllers\admin\organizationController;
use App\Http\Controllers\admin\Permission\PermissionController;
use App\Http\Controllers\admin\Role\RoleController;
use App\Http\Controllers\admin\userController;
use App\Http\Controllers\api\APIController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\CommonController;
use App\Http\Controllers\ProfileController;
use App\Models\Locations\Country;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');


Route::get('register', [CommonController::class, 'register'])->name('user.register');
Route::get('login', [CommonController::class, 'login'])->name('user.login');
Route::post('/two-step-varification', [CommonController::class, 'twoStepVarification'])->name('user.two-step-varification');
Route::post('/send-otp', [CommonController::class, 'sendOtp'])->name('send-otp');
Route::post('/verify-otp', [CommonController::class, 'verifyOtp'])->name('verify-otp');
Route::post('/verify-otp-login', [CommonController::class, 'verifyOtpLogin'])->name('verify-otp-login');
Route::get('/email-varification', [CommonController::class, 'otp_form'])->name('otp.form');
Route::get('/user-authentication', [CommonController::class, 'otp_form_login'])->name('otp.form.login');
Route::get('/invite/accept/{user_slug}', [CommonController::class, 'accept_invitation'])->name('user.invitation.accept');
Route::get('/set-password/{slug}', [CommonController::class, 'set_password'])->name('user.set_password');
Route::post('/update-password/{slug}', [CommonController::class, 'update_password'])->name('user.update_password');

Route::get('/enter-details', [CommonController::class, 'userDetailsPage'])->name('enter.user.details');
Route::post('/submit-user-details', [CommonController::class, 'submitUserDetails'])->name('submit.user.details');
Route::post('/submit-organization-details', [CommonController::class, 'submitOrganizationDetails'])->name('submit.organization.details');

Route::get('/organization-details', [CommonController::class, 'organizationDetailsPage'])->name('enter.organization.details');



Route::middleware(['auth', 'verified'])->group(function () {
//    Route::get('/about-user', [CommonController::class, 'aboutUSer'])->name('user.about-user');
});


/*Route::get('/dashboard', [dashboardController::class, 'main_dashboard'])->middleware(['auth', 'verified'])->name('dashboard');
Route::resource('users', userController::class)->middleware(['auth', 'verified']);*/

Route::middleware(['auth', 'verified']) ->prefix('admin')->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('users', UserController::class);
    Route::resource('organization', organizationController::class);

    Route::resource('roles', RoleController::class);
    Route::resource('permissions', PermissionController::class);

    Route::prefix('master')->name('master.')->group(function () {
        Route::resource('goals', GoalController::class)->names('goals');
        Route::get('skills/europa-skills', [SkillController::class, 'europaSkillsPage'])->name('skills.europa-skills');
        Route::post('skills/europa-skills', [SkillController::class, 'storeEuropaSkills'])->name('skills.europa-skills.store');
        Route::resource('skills', SkillController::class)->names('skills');

    });
});

Route::prefix('api')->group(function () {
    Route::post('/create-new-goal', [APIController::class, 'createNewGoal'])->name('create-new-goal');
    Route::get('/countryList', [APIController::class, 'countryList']);
    Route::get('/stateList/{country_id}', [APIController::class, 'states']);
    Route::get('/cityList/{state_id}', [APIController::class, 'cities']);
    Route::get('/industryType', [APIController::class, 'industryType']);
    Route::get('/europa-skills', [APIController::class, 'get_europa_skills']);
});

require __DIR__.'/frontend-routes.php';
require __DIR__.'/payment.php';
require __DIR__.'/google-auth.php';
require __DIR__.'/linkedin-auth.php';
require __DIR__.'/auth.php';
