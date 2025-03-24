<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SuperAdminAuthController;
use App\Http\Controllers\UserAuthController;
use App\Http\Controllers\userController;
use App\Http\Controllers\organisationDepartmentController;
use App\Http\Controllers\organisationDesignationController;
use App\Http\Controllers\ororganisationBranchController;
use App\Http\Controllers\permissionController;
use App\Http\Controllers\empDetailFormController;
use App\Http\Controllers\homePagecontroller;
use App\Http\Controllers\headerController;
use App\Http\Controllers\employmentDataController;
use App\Http\Controllers\ororganisationMailConController;
use App\Http\Controllers\hrPolicyViewController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\settingController;
use App\Http\Controllers\organisationController;
use App\Http\Controllers\leavePolicyController;
use App\Http\Controllers\editUserController;




/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('superadmin/login', [SuperAdminAuthController::class, 'showLoginForm'])->name('superadmin.login');
Route::post('superadmin/login', [SuperAdminAuthController::class, 'login']);
Route::get('superadmin/logout', [SuperAdminAuthController::class, 'logout'])->name('superadmin.logout');
//super admin routes
Route::get('superadmin/account_suspended',function(){
    return view('superadmin_view.account_suspended');
})->name('account_suspended');

Route::middleware(['auth.superadmin'])->group(function () {

    Route::get('superadmin/dashboard', function () {
        return view('dashboard.superadmin');
    })->name('superadmin.dashboard');
//User Controller Routes
    Route::get('superadmin/create_user',[userController::class,'index'])->name('create_user');
    Route::post('superadmin/register_user',[userController::class,'register'])->name('register_save');
    Route::post('superadmin/update_user', [userController::class, 'update'])->name('update_user');
    //Department Controller Routes
    Route::get('superadmin/create_department',[organisationDepartmentController::class,'index'])->name('create_department_form');
    Route::post('superadmin/save_department',[organisationDepartmentController::class,'insertDepartment'])->name('insert_department');
    Route::post('superadmin/update_department', [organisationDepartmentController::class, 'update'])->name('update_department');
    //Designations Controller Routes
    Route::get('superadmin/create_designation',[organisationDesignationController::class,'index'])->name('create_designation_form');
    Route::post('superadmin/save_desihnation',[organisationDesignationController::class,'insertDesignation'])->name('insert_designation');
    //branch controller route
    Route::get('superadmin/create_branch',[ororganisationBranchController::class,'index'])->name('create_branch_form');
    Route::POST('superadmin/insert_branch',[ororganisationBranchController::class,'insertBranch'])->name('insert_branch');
    Route::post('superadmin/update_branch', [ororganisationBranchController::class, 'update'])->name('update_branch');
    //permission controller rolute
    Route::get('superadmin/create_permission/{org_id}/{desig_id}/{b_id}',[permissionController::class,'index'])->name('create_permission_form');
    Route::post('superadmin/save_permission/{org_id}/{desig_id}/{b_id}',[permissionController::class,'insertPermission'])->name('insert_permission');
    Route::get('superadmin/create_mail_config',[ororganisationMailConController::class,'index'])->name('load_mail_config_form');
    Route::post('superadmin/insert_config',[ororganisationMailConController::class,'insertMailConfig'])->name('insert_configuration');
    //hr policy controller routes
    Route::get('superadmin/create_policy_category', [hrPolicyViewController::class, 'createPolicyCategory'])->name('create_policy_category');
    Route::post('superadmin/save_policy_category', [hrPolicyViewController::class, 'savePolicyCategory'])->name('save_policy_category');

    Route::get('superadmin/create_hr_policy', [hrPolicyViewController::class, 'createHrPolicy'])->name('create_hr_policy');
    Route::post('superadmin/save_hr_policy', [hrPolicyViewController::class, 'saveHrPolicy'])->name('save_hr_policy');
    
    Route::post('superadmin/update_policy_category/{id}', [hrPolicyViewController::class, 'updatePolicyCategory'])->name('update_policy_category');

    Route::get('superadmin/create_organisation', [organisationController::class, 'index'])->name('create_organisation_form');
    Route::post('superadmin/insert_organisation', [organisationController::class, 'insert'])->name('insert_organisation');
    Route::post('superadmin/update_organisation', [organisationController::class, 'update'])->name('update_organisation');

    // Route::post('superadmin/save_thought', [settingController::class, 'saveThought'])->name('save_thought');
    // Route::post('superadmin/save_news_events', [settingController::class, 'saveNewsEvents'])->name('save_news_events');
   //Load pages routes leavePolicyController superadmin
    Route::get('superadmin/create_leave_slot',[leavePolicyController::class,'loadPolicyTimeSlot'])->name('create_policy_time_slot');
    Route::get('superadmin/create_leave_policy_type',[leavePolicyController::class,'loadPolicyType'])->name('create_policy_type');
    Route::get('superadmin/create_leave_policy',[leavePolicyController::class,'loadPolicy'])->name('create_policy');
    Route::get('superadmin/employee_policy',[leavePolicyController::class,'loadEmpPolicy'])->name('employee_policy');

    //Insert routess leavePolicyController superadmin
     
    Route::post('superadmin/insert_policy_slot',[leavePolicyController::class,'insertPolicyTimeSlot'])->name('insert_policy_slot');
    Route::post('superadmin/insert_policy_type',[leavePolicyController::class,'insertPolicyType'])->name('insert_policy_type');
    Route::post('superadmin/insert_policy_restriction',[leavePolicyController::class,'insertPolicyConf'])->name('insertPolicyConf');
    Route::post('superadmin/insert_emp_restriction',[leavePolicyController::class,'insertEmpRestriction'])->name('insert_emp_restriction');

 

    
    
    
    
});

//user end route
Route::get('/', [UserAuthController::class, 'showLoginForm'])->name('user.login');
Route::post('/', [UserAuthController::class, 'login']);
Route::post('user/logout', [UserAuthController::class, 'logout'])->name('user.logout');

//forgot password routes

Route::get('password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('password/reset/{token}', [ForgotPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('password/reset', [ForgotPasswordController::class, 'reset'])->name('password.update');

Route::get('user/account_suspended',function(){
    return view('user_view.account_suspended');
})->name('user_account_suspended');


Route::middleware(['auth'])->group(function () {
    Route::get('user/dashboard',[empDetailFormController::class,'index'])->name('user.dashboard');
    Route::get('user/contact',[empDetailFormController::class,'loadcontectuser'])->name('user.contact');
    Route::get('user/edu',[empDetailFormController::class,'loadeducationuser'])->name('user.edu');
    Route::get('user/bank',[empDetailFormController::class,'loadbankuser'])->name('user.bank');
    Route::get('user/family',[empDetailFormController::class,'loadfamilyuser'])->name('user.family');
    Route::get('user/preemp',[empDetailFormController::class,'loadpreempuser'])->name('user.preemp');
    Route::get('user/docupload',[empDetailFormController::class,'loaddocuploaduser'])->name('user.docupload');
//load department according to branch_id
    Route::get('user/fetch_department/{branch_id}',[empDetailFormController::class,'fetchDepartmentBrach'])->name('fetch_department_branch');
    Route::get('user/fetch_designation/{department_id}',[empDetailFormController::class,'fetchDesignationBrach'])->name('fetch_department_branch');
   
    //Edit user Controller routes

    Route::get('user/edit/dashboard/{id}',[editUserController::class,'index'])->name('user.editdashboard');
    Route::get('user/edit/contact/{id?}',[editUserController::class,'loadcontectuser'])->name('user.editcontact');
    Route::get('user/edit/edu/{id?}',[editUserController::class,'loadeducationuser'])->name('user.editedu');
    Route::get('user/edit/bank/{id?}',[editUserController::class,'loadbankuser'])->name('user.editbank');
    Route::get('user/edit/family/{id?}',[editUserController::class,'loadfamilyuser'])->name('user.editfamily');
    Route::get('user/edit/preemp/{id?}',[editUserController::class,'loadpreempuser'])->name('user.editpreemp');
    Route::get('user/edit/docupload/{id?}',[editUserController::class,'loaddocuploaduser'])->name('user.editdocupload');

    //load department according to branch_id
    Route::get('user/edit/fetch_department/{branch_id}',[empDetailFormController::class,'fetchDepartmentBrach'])->name('fetch_editdepartment_branch');
    Route::get('user/edit/fetch_designation/{department_id}',[empDetailFormController::class,'fetchDesignationBrach'])->name('fetch_editdepartment_branch');

    //Update edit users Routes
    Route::post('user/edit/detail_insert',[editUserController::class,'insertDetail'])->name('edit_detail_insert');
    Route::post('user/edit/contact_insert',[editUserController::class,'insertcontact'])->name('edit_contact_insert');
    Route::post('user/edit/education_insert',[editUserController::class,'insertEducation'])->name('edit_education_insert');
    Route::post('user/edit/bank_insert',[editUserController::class,'insertBank'])->name('edit_bank_insert');
    Route::post('user/edit/family_insert',[editUserController::class,'insertfamity'])->name('edit_family_insert');
    Route::post('user/edit/preemp_insert',[editUserController::class,'insertPreEmp'])->name('edit_preEmp_insert');
    Route::post('/user/edit/documents_upload', [editUserController::class, 'upload'])->name('edit_documents.upload');

    //Delete data

    Route::delete('user/edit/del_education/{id}', [editUserController::class, 'DeleteEducation'])->name('edit_edu.destroy');
    Route::delete('user/edit/del_family/{id}', [editUserController::class, 'DeleteFamily'])->name('edit_family.destroy');
    Route::delete('user/edit/pre_emply/{id}', [editUserController::class, 'DeletePreViousEmpy'])->name('edit_previous.destroy');



    Route::get('user/homepage',[homePagecontroller::class,'showHomepage'])->name('user.homepage');
    Route::post('user/save_todo',[homePagecontroller::class,'saveToDoList'])->name('user.save_todo');
    Route::put('user/edit_to_do/{id}',[homePagecontroller::class,'updateToDo'])->name('update_do_do');
    Route::put('user/approve_leave_status/{id}/{status}',[homePagecontroller::class,'updateLeaveStatus'])->name('leave_update_status');


    Route::get('user/header', [headerController::class, 'showHeader'])->name('header');
    Route::post('/user/upload-profile-photo', [headerController::class, 'uploadProfilePhoto'])->name('user.uploadProfilePhoto');
    Route::get('user/employment-data', [employmentDataController::class, 'showemploymentData'])->name('user.employment.data');
    Route::get('user/hr-policy', [hrPolicyViewController::class, 'showHrPolicy'])->name('user.hr.policy');
    Route::get('user/hr-policy/category/{id}', [hrPolicyViewController::class, 'getPoliciesByCategory'])->name('user.hr.policy.category');
    Route::get('user/setting', [settingController::class, 'showsetting'])->name('user.setting');
    Route::get('user/organisation', [organisationController::class, 'showOrganisation'])->name('user.view_organisation');
    Route::get('user/horizontal_organisation', [OrganisationController::class, 'showHorizontalOrganisation'])->name('user.view.horizontal.organisation');

    //Insert data

    Route::post('user/detail_insert',[empDetailFormController::class,'insertDetail'])->name('detail_insert');
    Route::post('user/contact_insert',[empDetailFormController::class,'insertcontact'])->name('contact_insert');
    Route::post('user/education_insert',[empDetailFormController::class,'insertEducation'])->name('education_insert');
    Route::post('user/bank_insert',[empDetailFormController::class,'insertBank'])->name('bank_insert');
    Route::post('user/family_insert',[empDetailFormController::class,'insertfamity'])->name('family_insert');
    Route::post('user/preemp_insert',[empDetailFormController::class,'insertPreEmp'])->name('preEmp_insert');
    Route::post('/user/documents_upload', [empDetailFormController::class, 'upload'])->name('documents.upload');

    //Delete data

    Route::delete('user/del_education/{id}', [empDetailFormController::class, 'DeleteEducation'])->name('edu.destroy');
    Route::delete('user/del_family/{id}', [empDetailFormController::class, 'DeleteFamily'])->name('family.destroy');
    Route::delete('user/pre_emply/{id}', [empDetailFormController::class, 'DeletePreViousEmpy'])->name('previous.destroy');

    //Redirect homepage

    Route::post('user/homePage',[empDetailFormController::class,'homePageRedirect'])->name('homePage');

    // Save Thought and News & Events
    Route::post('user/save_thought', [settingController::class, 'saveThought'])->name('save_thought');
    Route::post('user/save_news_events', [settingController::class, 'saveNewsEvents'])->name('save_news_events');
    Route::post('user/save_calendra_master', [settingController::class, 'createCalendraMaster'])->name('create_calendra_master');

       //userend

       Route::get('user/leave_dashboard',[leavePolicyController::class,'showLeaveDashboard'])->name('leave_dashboard');
       Route::get('user/leave_request',[leavePolicyController::class,'showLeaveRequest'])->name('leave_request');
       Route::get('user/remaning_leave/{leave_id}',[leavePolicyController::class,'fetchRemainingLeave'])->name('remaing_leave');
       Route::get('user/half_days_status/{leave_id}/{start_date}/{end_date}',[leavePolicyController::class,'fetchStatusHalfDay'])->name('half_day_status');
       Route::post('user/insert_leave',[leavePolicyController::class,'insertLeave'])->name('insert_leave');
       Route::put('user/update_leave_status/{id}',[leavePolicyController::class,'updateLeaveStatusByUser'])->name('update_leave_status_by_user');
     

   
});

