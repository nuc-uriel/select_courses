<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::match(['get', 'post'], '/', 'LoginController@login');
Route::get('/captcha', 'LoginController@captcha');
Route::get('/logout', 'LoginController@logout');
Route::group(['prefix'=>'/admin', 'middleware' => 'admin_auth'], function (){
    Route::get('/', 'UserController@teacher_list');
    Route::get('/teacher', 'UserController@teacher_list');
    Route::post('/teacher/add', 'UserController@add_teacher');
    Route::post('/teacher/update', 'UserController@update_teacher');
    Route::get('/teacher/delete', 'UserController@delete_teacher');
    Route::get('teacher/reset', 'UserController@reset_password');
    Route::get('/student', 'UserController@student_list');
    Route::post('/student/add', 'UserController@add_student');
    Route::post('/student/update', 'UserController@update_student');
    Route::get('/student/delete', 'UserController@delete_student');
    Route::get('/student/reset', 'UserController@reset_password');
    Route::get('/course', 'CourseController@course_list');
    Route::post('/course/add', 'CourseController@add_course');
    Route::post('/course/update', 'CourseController@update_course');
    Route::get('/course/delete', 'CourseController@delete_course');
    Route::get('/course/info', 'CourseController@course_student_list');
});

Route::group(['prefix'=>'/teacher', 'middleware' => 'teacher_auth'], function (){
    Route::get('/', 'UserController@center');
    Route::get('/course', 'CourseController@course_list');
    Route::post('/course/add', 'CourseController@add_course');
    Route::post('/course/update', 'CourseController@update_course');
    Route::get('/course/delete', 'CourseController@delete_course');
    Route::get('/course/info', 'CourseController@course_student_list');
    Route::get('/center', 'UserController@center');
    Route::post('/reset', 'UserController@reset_password');
});

Route::group(['prefix'=>'/student', 'middleware' => 'student_auth'], function (){
    Route::get('/', 'UserController@center');
    Route::get('/sc', 'CourseController@course_list');
    Route::get('/sc/select', 'UserController@select_course');
    Route::get('/scr', 'CourseController@course_list');
    Route::get('/scr/un_select', 'UserController@un_select_course');
    Route::get('/center', 'UserController@center');
    Route::post('/reset', 'UserController@reset_password');
});