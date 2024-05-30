<?php

use App\Http\Controllers\ClassroomController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\StudentController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Api\ApiController;
use App\Http\Controllers\GradeController;
use App\Http\Controllers\Report_ItemController;
use App\Http\Controllers\SubjectController;
use App\Models\Teacher;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\EnrollmentController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\Subject_ItemController;
use App\Http\Controllers\MonthController;
use App\Models\Grade;

// Route::get('/user', function (Request $request) {
// return $request->user();
// })->middleware('auth:sanctum');

//Register Route    
Route::post("register", [ApiController::class, "register"]);
Route::post("login", [ApiController::class, "login"]);

// Protected routes for the main API controller
Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get("profile", [ApiController::class, "profile"]);
    Route::get("logout", [ApiController::class, "logout"]);
});

// Classroom routes
Route::post("classroom", [ClassroomController::class, "create"]);
Route::get("classroom", [ClassroomController::class, "index"]);
Route::put("classroom/{id}", [ClassroomController::class, "update"]);
Route::delete("classroom/{id}", [ClassroomController::class, "delete"]);
Route::get("classroom/{id}", [ClassroomController::class, "getbyid"]);

// Teacher routes
Route::post("teacher", [TeacherController::class, "create"]);
Route::post("teacher/login", [TeacherController::class, "teacherlogin"]);
Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get("teacher/logout", [TeacherController::class, 'teacher_logout']);
    Route::get('teacher/profile', [TeacherController::class, 'profile']);
});

// Student routes
Route::post("student/register", [StudentController::class, "register"]);
Route::post("student/login", [StudentController::class, "login"]);
Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get("student/profile", [StudentController::class, "profile"]);
    Route::get('student/logout', [StudentController::class, 'logout']);
});

// Register routes for GradeController
Route::post('grade', [GradeController::class, 'create']);
Route::get('grades', [GradeController::class, 'index']);
Route::put('grade/{id}', [GradeController::class, 'update']);
Route::delete('grade/{id}', [GradeController::class, 'delete']);

// Subject Route
Route::post('subject', [SubjectController::class, 'create']);
Route::get('subjects', [SubjectController::class, 'index']);
Route::put('subject/{id}', [SubjectController::class, 'update']);
Route::delete('subject/{id}', [SubjectController::class, 'delete']);
//report_item 

Route::post('report_item', [Report_ItemController::class, 'create']);
Route::get('reports_item', [Report_ItemController::class, 'index']);
Route::put('report_item/{id}', [Report_ItemController::class, 'update']);
Route::delete('report_item/{id}', [Report_ItemController::class, 'delete']);
Route::get('report_item/{id}', [Report_ItemController::class, 'getbyid']);

// Define the report routes
Route::post('report', [ReportController::class, 'create']);
Route::get('reports', [ReportController::class, 'index']);
Route::put('report/{id}', [ReportController::class, 'update']);
Route::delete('report/{id}', [ReportController::class, 'delete']);
Route::get('report/{id}', [ReportController::class, 'getbyid']);


Route::get('enrollments', [EnrollmentController::class, 'index']);
Route::post('enrollment', [EnrollmentController::class, 'create']);
Route::put('enrollment/{id}', [EnrollmentController::class, 'update']);
Route::delete('enrollment/{id}', [EnrollmentController::class, 'delete']);
Route::get('enrollment/{id}', [EnrollmentController::class, 'getbyid']);



Route::get('subject_items', [Subject_ItemController::class, 'index']);
Route::get('subject_items/{id}', [Subject_ItemController::class, 'getbyid']);
Route::post('subject_items', [Subject_ItemController::class, 'create']);
Route::put('subject_items/{id}', [Subject_ItemController::class, 'update']);
Route::delete('subject_items/{id}', [Subject_ItemController::class, 'delete']);



//Route Role 
Route::get('roles', [RoleController::class, 'index']);
Route::get('role/{id}', [RoleController::class, 'getbyid']);
Route::put('role/{id}', [RoleController::class, 'update']);
Route::delete('role/{id}', [RoleController::class, 'delete']);
Route::post('role', [RoleController::class, 'create']);


// Month Controller 

Route::get('months', [MonthController::class, 'index']);
Route::post('months', [MonthController::class, 'create']);
Route::delete('months/{id}', [MonthController::class, 'delete']);