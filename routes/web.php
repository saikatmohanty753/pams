<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TaskManagementController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\MastersController;
use App\Http\Controllers\ProjectsController;
use App\Http\Controllers\TaskActivityController;
use App\Http\Controllers\ReportsController;
use Illuminate\Support\Facades\Hash;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/getpass',function(){
    return Hash::make(123);
});

Route::get('change-msg-password',function(){
    Auth::logout();
    session()->flush();
    return view('users.change_password_msg');
});

Route::get('/', function () {
    if(Auth::check())
    {
        return redirect('/dashboard');
    }
    return view('users.login');
});

Route::get('/login', function () {
    if(Auth::check())
    {
        return redirect('/dashboard');
    }
    return view('users.login');
});

Route::get('logout',function(){
    Auth::logout();
    session()->flush();
    return redirect('/');
})->name('logout');

Route::controller(UsersController::class)->group(function(){

    Route::get('reload-captcha', 'reloadCaptcha');

    Route::post('/login','login')->name('login');
    Route::get('forgot-password','forgotPassword')->name('forgot-password');

    Route::post('send-forgot-password','forgotPassword')->name('send-forgot-password');

    Route::prefix('admin')->middleware(['auth','permission:user-module'])->group(function(){
        /* Users master */
        Route::post('update-profile','updateProfile')->middleware('can:user-edit')->name('update-profile');
        Route::get('index','index')->middleware('can:user-create')->name('user-index');
        Route::get('add-user','addUser')->middleware('can:user-create')->name('addUser');
        Route::post('add-user','addUser')->middleware('can:user-create')->name('addUserSave');
        Route::get('edit-user/{id?}','updateUser')->middleware('can:user-edit')->name('edit-user');
        Route::post('update-user','updateUser')->middleware('can:user-edit')->name('update-user');
        Route::get('delete-user/{id?}','deleteUser')->middleware('can:user-delete')->name('delete-user');

        /* Change Password */
        Route::get('change-password','changePassword')->name('change-password');
        Route::post('change-password','changePassword')->name('update-change-password');
    });

});

Route::controller(MastersController::class)->middleware(['auth','permission:master-module'])->group(function(){

    /* Reporting Designation */
    Route::get('add-report','reportDesignation')->middleware('can:master-create')->name('add-report');
    Route::get('edit-report/{id?}','editReportingDesignation')->middleware('can:master-edit')->name('edit-report');
    Route::get('delete-report/{id?}','deleteReportingDesignation')->middleware('can:master-delete')->name('delete-report');
    Route::post('save-report','saveReportDesig')->middleware('can:master-list')->name('save-create');
    Route::post('update-report','updateReportDesig')->middleware('can:master-edit')->name('update-report');

    /* Department Master */
    Route::get('add-department','addDepartment')->middleware('can:master-create')->name('add-department');
    Route::post('save-department','saveDepartment')->middleware('can:master-create')->name('save-department');
    Route::get('edit-department/{id}','editDepartment')->middleware('can:master-edit')->name('edit-department');
    Route::post('update-department','updateDepartment')->middleware('can:master-edit')->name('update-department');

    /* Sub Department Master */
    Route::get('add-sub-department','subDepartment')->middleware('can:master-create')->name('add-sub-department');
    Route::post('save-sub-department','saveSubDepartment')->middleware('can:master-create')->name('save-sub-department');
    Route::get('edit-sub-department/{id}','editSubDepartment')->middleware('can:master-edit')->name('edit-sub-department');
    Route::post('update-sub-department','updateSubDepartment')->middleware('can:master-edit')->name('update-sub-department');
    Route::get('get-sub-dept','getSubDepartment')->name('get-sub-dept');

    /* Designation Master */
    Route::get('add-designation','addDesignation')->middleware('can:master-create')->name('add-designation');
    Route::post('save-designation','saveDesignation')->middleware('can:master-create')->name('save-designation');
    Route::get('edit-designation/{id}','editDesignation')->middleware('can:master-edit')->name('edit-designation');
    Route::post('update-designation','updateDesignation')->middleware('can:master-edit')->name('update-designation');
});

Route::prefix('admin')->controller(RoleController::class)->middleware(['auth','permission:role-module'])->group(function(){

    Route::post('get-roles','getRole')->middleware('can:role-list')->name('get-roles');
    Route::get('add-role','index')->middleware('can:role-create')->name('add-role');
    Route::get('edit-role/{id?}','edit')->middleware('can:role-edit')->name('edit-role');
    Route::post('save-role','store')->middleware('can:role-create')->name('save-role');
    Route::post('update-role','updateRole')->middleware('can:role-edit')->name('update-role');
});

Route::prefix('task')->controller(ProjectsController::class)->middleware(['auth','can:project-module'])->group(function(){
    /* Project Master */
    Route::get('add-project','projectAdd')->middleware('can:project-create')->name('add-project');
    Route::get('edit-project/{id?}','projectEdit')->middleware('can:project-edit')->name('edit-project');
    Route::post('save-project','saveProject')->middleware('can:project-create')->name('save-project');
    Route::post('update-project','updateProject')->middleware('can:project-edit')->name('update-project');
    Route::get('project-list','projectList')->middleware('can:project-list')->name('project-list');
    Route::get('delete-project/{id?}','deleteProject')->middleware('can:project-delete')->name('delete-project');

    /* Project Assign */
    Route::post('assign-project','assignProject')->name('assign-project');

});

Route::prefix('task')->controller(TaskManagementController::class)->middleware(['auth','permission:task-module'])->group(function(){

    Route::get('add-task','index')->middleware('can:task-list')->name('add-task');
    Route::get('task-assign-list-ajax','taskAssignListAjax')->name('task-assign-list-ajax');
    Route::get('task-observe-list-ajax','taskObserver')->name('task-observe-list-ajax');
    Route::get('task-team-list-ajax','taskTeam')->name('task-team-list-ajax');
    Route::post('get-dept-user','getDepartmentUser')->name('get-dept-user');
    Route::post('create-task','store')->middleware('can:task-create')->name('create-task');
    Route::post('update-task','update')->middleware('can:task-edit')->name('update-task');
    Route::get('delete-task/{id}','destroy')->middleware('can:task-delete')->name('delete-task');

    Route::post('create-sub-task','createSubTask')->middleware('can:task-create')->name('create-sub-task');
    Route::get('task-list/{id}','taskDetailsList')->middleware('can:task-list')->name('task-list');



});

Route::prefix('task-updates')->controller(TaskActivityController::class)->middleware(['auth','permission:task-module'])->group(function(){

    Route::get('view-details/{id?}','index')->name('view-task-details');

    /* Task Update */
    Route::get('assign-task-update/{id}','taskUpdate')->name('assign-task-update');
    Route::post('start-task','startTask')->name('start-task');
    Route::post('finish-task','finishTask')->name('finish-task');
    Route::post('reopen-task','reopenTask')->name('reopen-task');

    Route::post('update-comment','saveComment')->name('update-comment');
    Route::get('show-comment','getComment')->name('show-comment');
    Route::post('delay-reason','delayReason')->name('delay-reason');
    Route::get('show-delay','showDelay')->name('show-delay');
    Route::post('time-elapsed','getTimeElapsed')->name('time-elapsed');
    Route::post('save-daily-report','saveDailyReport')->name('save-daily-report');
    Route::get('daily-report','dailyReport')->name('daily-report');
    Route::post('daily-reply-report','saveReplyDailyReport')->name('daily-reply-report');
    Route::post('daily-seen-report','isReplyReadDailyReport')->name('daily-seen-report');
});

Route::controller(DashboardController::class)->middleware(['auth'])->group(function(){
    Route::get('/dashboard','index');
});

Route::prefix('reports')->controller(ReportsController::class)->middleware(['auth'])->group(function(){
    Route::get('reports','index')->name('reports');
    Route::get('reports-list','getReportList')->name('reports-list');
    Route::get('project-reports-list','projectWiseList')->name('project-reports-list');
    Route::get('project-reports-list-ajax','projectWiseListAjax')->name('project-reports-list-ajax');
    Route::get('other-reports-list','otherReport')->name('other-reports-list');
    Route::get('other-reports-list-ajax','otherReportAjax')->name('other-reports-list-ajax');
});

Route::get('read/{filename}',[TaskActivityController::class,'getFileRead']);
