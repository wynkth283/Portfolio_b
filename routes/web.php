<?php

use Illuminate\Support\Facades\Route;
use Laravel\Sanctum\PersonalAccessToken;

// Route logout (không cần middleware)
Route::get('/admin/logout', function () {
    // Lấy token từ session
    $token = session('admin_token');
    
    // Xóa token khỏi database (revoke token)
    if ($token) {
        $accessToken = PersonalAccessToken::findToken($token);
        if ($accessToken) {
            $accessToken->delete();
        }
    }
    
    // Xóa session
    session()->forget('admin_token');
    session()->forget('admin_user');
    session()->flush();
    
    // Redirect về frontend với flag logout
    return redirect(env('FRONTEND_URL') . '/?logout=true');
})->name('admin.logout');

// Áp dụng middleware 'admin' cho tất cả các routes quản trị
Route::middleware(['admin'])->group(function () {
    Route::get('/', function () {
        return view('pages.Dashboard');
    });
    
    Route::get('/users', function () {
        return view('pages.Users');
    });
    
    Route::get('/skills', function () {
        return view('pages.Skills');
    });
    
    Route::get('/skills-title', function() {
        return view('pages.SkillsTitle');
    });
    
    Route::get('/projects', function() {
        return view('pages.Projects');
    });
    
    Route::get('/project-links', function() {
        return view('pages.ProjectLink');
    });
});