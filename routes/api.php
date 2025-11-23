<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\TitleSkillController;
Route::get('/title-skills/DataTableGetAll', [TitleSkillController::class, 'DataTableGetAll']);
Route::get('/title-skills/getAll', [TitleSkillController::class, 'getAll']);
Route::post('/title-skills', [TitleSkillController::class, 'create']);
Route::get('/title-skills/{id}', [TitleSkillController::class, 'show']);
Route::put('/title-skills/{id}', [TitleSkillController::class, 'update']);
Route::delete('/title-skills/{id}', [TitleSkillController::class, 'delete']);

use App\Http\Controllers\SkillController;
Route::get('/skills/DataTableGetAll', [SkillController::class, 'DataTableGetAll']);
Route::get('/skills/getAll', [SkillController::class, 'getAll']);
Route::post('/skills', [SkillController::class, 'create']);
Route::get('/skills/{id}', [SkillController::class, 'show']);
Route::put('/skills/{id}', [SkillController::class, 'update']);
Route::delete('/skills/{id}', [SkillController::class, 'delete']);

use App\Http\Controllers\UserController;
Route::get('/users/DataTableGetAll', [UserController::class, 'DataTableGetAll']);
Route::get('/users/getAll', [UserController::class, 'getAll']);
Route::post('/users', [UserController::class, 'create']);
Route::post('/users/register', [UserController::class, 'register']);
Route::get('/users/{id}', [UserController::class, 'show']);
Route::put('/users/{id}', [UserController::class, 'update']);
Route::put('/users/auth/{id}', [UserController::class, 'updateUserAuth']);
Route::middleware('auth:sanctum')->put('/users/passwordchange/{id}', [UserController::class, 'passwordchange']);
Route::delete('/users/{id}', [UserController::class, 'delete']);


use App\Http\Controllers\CommentController;
Route::get('/comments', [CommentController::class, 'comments']);
Route::middleware('auth:sanctum')->post('/comments', [CommentController::class, 'create']);
Route::middleware('auth:sanctum')->delete('/comments/{id}', [CommentController::class, 'delete']);

use App\Http\Controllers\ProjectController;
Route::get('/projects/DataTable', [ProjectController::class, 'DataTable']);
Route::get('/projects', [ProjectController::class, 'projects']);
Route::post('/projects', [ProjectController::class, 'create']);
Route::get('/projects/{id}', [ProjectController::class, 'show']);
Route::put('/projects/{id}', [ProjectController::class, 'update']);
Route::delete('/projects/{id}', [ProjectController::class, 'delete']);

use App\Http\Controllers\ProjectLinkController;
Route::get('/project-links/DataTable', [ProjectLinkController::class, 'DataTable']);
Route::get('/project-links', [ProjectLinkController::class, 'project_links']);
Route::post('/project-links', [ProjectLinkController::class, 'create']);
Route::get('/project-links/{id}', [ProjectLinkController::class, 'show']);
Route::put('/project-links/{id}', [ProjectLinkController::class, 'update']);
Route::delete('/project-links/{id}', [ProjectLinkController::class, 'delete']);

use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;

Route::post('/login', [AuthController::class, 'login']);
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);

use App\Http\Controllers\ForgotPasswordController;
Route::post('/forgot-password', [ForgotPasswordController::class, 'sendOtp']);
Route::post('/verify-otp', [ForgotPasswordController::class, 'verifyOtp']);
Route::post('/reset-password', [ForgotPasswordController::class, 'resetPassword']);
