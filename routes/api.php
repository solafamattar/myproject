<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\VolunteerController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\SupervisorController;


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
Route::post('add_volunteer',[VolunteerController::class, "add_volunteer"]);
Route::post('add_supervisor',[SupervisorController::class, "add_supervisor"]);
Route::post('log_in',[UserController::class, "login"]);
Route::post('forget_password',[UserController::class,"forget_password"]);
Route::post('check_forget_code',[UserController::class,"check_forget_code"]);
Route::post('reset_password',[UserController::class,"reset_password"]);
Route::group(["middleware"=>["auth:sanctum"]],function(){
    Route::post('add_volunteer',[VolunteerController::class, "add_volunteer"]);
    Route::post('add_group',[GroupController::class, "add_group"]);
    Route::post('add_supervisor',[SupervisorController::class, "add_supervisor"]);
    Route::post('log_out',[UserController::class, "logout"]);
    Route::get('Volunteer_profile',[VolunteerController::class,'Volunteer_profile']);
    Route::get('Supervisor_profile',[SupervisorController::class,'Supervisor_profile']);
    Route::post('update_volunteer_profile',[VolunteerController::class,'update_volunteer_profile']);
    Route::post('update_supervisor_profile',[SupervisorController::class,'update_supervisor_profile']);
    Route::post('admin_update_volunteer_profile',[VolunteerController::class,'admin_update_volunteer_profile']);
    Route::post('admin_update_supervisor_profile',[SupervisorController::class,'admin_update_supervisor_profile']);
});
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
