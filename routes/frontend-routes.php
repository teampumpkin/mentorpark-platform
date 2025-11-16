<?php

use App\Http\Controllers\Frontend\CalendarController;
use App\Http\Controllers\Frontend\DashboardController;
use App\Http\Controllers\admin\Master\GoalController;
use App\Http\Controllers\admin\Master\SkillController;
use App\Http\Controllers\admin\organizationController;
use App\Http\Controllers\admin\Permission\PermissionController;
use App\Http\Controllers\admin\Role\RoleController;
use App\Http\Controllers\Frontend\MasterClassesController;
use App\Http\Controllers\Frontend\MenteeController;
use App\Http\Controllers\Frontend\OrgController;
use App\Http\Controllers\Frontend\ProfileController;
use App\Http\Controllers\Frontend\UserController;
use App\Http\Controllers\api\APIController;
use App\Http\Controllers\mentor\MentorController;
use App\Http\Controllers\OrdersController;
use App\Models\Locations\Country;
use Illuminate\Support\Facades\Route;


/*Route::get('/dashboard', [dashboardController::class, 'main_dashboard'])->middleware(['auth', 'verified'])->name('dashboard');
Route::resource('users', userController::class)->middleware(['auth', 'verified']);*/


Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('frontend.dashboard');
    Route::get('/mentor-dashboard', [MentorController::class, 'dashboard'])->name('frontend.mentor.dashboard');

    Route::post('/set-user-role', [UserController::class, 'setUserRole'])->name('set.user.role');

    Route::get('/about', [UserController::class, 'about_user'])->name('frontend.about');
    Route::post('/user/about', [UserController::class, 'storeAbout'])->name('frontend.user.about.store');
    Route::post('/user/save-goals', [UserController::class, 'saveGoals'])->name('frontend.user.save.goals');


    Route::get('/my-account', [ProfileController::class, 'index'])->name('frontend.profile');
    Route::post('/user/about/store', [ProfileController::class, 'updateProfile'])->name('frontend.update.profile');

    Route::get('/master-class', [MasterClassesController::class, 'index'])->name('frontend.master-classes');
    Route::get('/master-classes/create', [MasterClassesController::class, 'create'])->name('frontend.master-classes.create');
    Route::get('/master-classes/edit/{masterClassSlug}', [MasterClassesController::class, 'edit'])->name('frontend.master-classes.edit');
//    Route::get('/master-classes/{slug}', [MasterClassesController::class, 'show'])->name('frontend.master-classes.show');
    Route::get('/master-class/{slug}', [MasterClassesController::class, 'show'])->name('frontend.master-classes.detail');
    Route::post('/create-master-class', [MasterClassesController::class, 'store'])->name('frontend.master-classes.store');
    Route::delete('/remove-mentee/{id}', [MasterClassesController::class, 'removeMentee'])->name('frontend.mentees.destroy');
    Route::delete('/remove-attachment/{id}', [MasterClassesController::class, 'removeAttachment'])->name('frontend.attachment.destroy');
//    Route::post('/edit-master-class', [MasterClassesController::class, 'edit'])->name('frontend.master-classes.edit');
    Route::put('/master-classes/{id}', [MasterClassesController::class, 'update'])->name('frontend.master-classes.update');
    Route::get('/master-class/add_sessions/{number}', [MasterClassesController::class, 'addMoreSessions'])->name('frontend.master-classes.add-more-sessions');
    Route::get('/master-class/add_sessions/{number}/feedback/{feedback_count}', [MasterClassesController::class, 'addMoreSessionsFeedback'])->name('frontend.master-classes.session.feedback');
    Route::get('/master-class/add_sessions/{number}/mentor/{count}', [MasterClassesController::class, 'addMoreSessionsMentor'])->name('frontend.master-classes.session.mentor');
    Route::get('/assignments', [MentorController::class, 'assignments'])->name('frontend.mentor.assignments');

//    Route::get('/user/calendar', [CalendarController::class, 'viewCalendarEvents'])->name('frontend.calendar.view');
    Route::get('/calendar', [CalendarController::class, 'viewCalendarEvents'])->name('frontend.calendar.view');


    // Organization
    Route::get('/overview', [OrgController::class, 'organizationDashboard'])->name('frontend.organization.dashboard');
    Route::get('/mentors', [OrgController::class, 'mentorList'])->name('frontend.organization.mentors');
    Route::get('/mentees', [OrgController::class, 'menteeList'])->name('frontend.organization.mentees');
    Route::get('/mentees-request', [OrgController::class, 'menteesRequest'])->name('frontend.organization.mentees-request');
    Route::post('/mentor/request/action', [OrgController::class, 'handleRequestAction'])->name('frontend.mentor.request.action');

    Route::get('/mentor/{organization_id}/add', [OrgController::class, 'createMentor'])->name('frontend.organization.mentors.add');
    Route::get('/mentee/{organization_id}/add', [OrgController::class, 'createMentee'])->name('frontend.organization.mentee.add');
    Route::get('/mentor/{organization_id}/profile/{mentor_id}', [OrgController::class, 'userProfile'])->name('frontend.organization.user.profile');
    Route::post('/mentor/{organization_id}/store', [OrgController::class, 'storeMentor'])->name('frontend.organization.mentors.store');
    Route::post('/mentee/{organization_id}/store', [OrgController::class, 'storeMentee'])->name('frontend.organization.mentee.store');



    // Mentee
    Route::get('/welcome-back', [MenteeController::class, 'menteeDashboard'])->name('frontend.mentee.dashboard');
    Route::get('/find-mentors', [MenteeController::class, 'mentorList'])->name('frontend.mentee.mentors');
    Route::get('/master-classes', [MenteeController::class, 'masterClasses'])->name('frontend.mentee.master-classes');
//    Route::get('/master-class/{slug}', [MenteeController::class, 'masterClassesDetail'])->name('frontend.mentee.master-classes.detail');
    Route::get('/mentor-detail/{mentor_id}', [MenteeController::class, 'mentorDetail'])->name('frontend.mentee.mentor.detail');
    Route::get('/find-mentors/{skill}', [MenteeController::class, 'mentorList'])->name('frontend.mentee.mentors.skill');
    Route::get('/mentor-search-suggestions', [MenteeController::class, 'searchSuggestions'])->name('frontend.mentee.mentor.search.suggestions');
    Route::post('/raise-request-to-organization', [MenteeController::class, 'raiseRequest'])->name('frontend.mentor.raise.request');
    Route::get('/my-sessions', [MenteeController::class, 'mySessions'])->name('frontend.mentee.my-sessions');
//    Route::post('/upload-assignment', [OrdersController::class, 'add_assignments'])->name('frontend.upload.assignment');
//    Route::post('/reupload-assignment', [OrdersController::class, 'reuploadAssignment'])->name('frontend.reupload.assignment');

    // Order Controller
    Route::post('/upload-assignment', [OrdersController::class, 'userUploadAssignment'])->name('frontend.user.upload.assignment');
    Route::post('/reupload-assignment', [OrdersController::class, 'userReuploadAssignment'])->name('frontend.reupload.assignment');
    Route::post('/organizer/upload-assignment', [OrdersController::class, 'organizerUploadAssignment'])->name('frontend.upload.assignment.organizer');
    Route::post('/organizer/re-upload-assignment', [OrdersController::class, 'organizerReUploadAssignment'])->name('frontend.reupload.assignment.organizer');
    Route::post('/user/assignment/mark-submitted', [OrdersController::class, 'markSubmitted'])->name('frontend.user.mark.submitted');
});
