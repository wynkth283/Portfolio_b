<?php

use Illuminate\Support\Facades\Route;

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
