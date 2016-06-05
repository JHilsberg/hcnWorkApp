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

Route::get('/', function () {
    return view('welcome');
});

// Authentication routes...
Route::get('auth/login', 'Auth\AuthController@getLogin');
Route::post('auth/login', 'Auth\AuthController@postLogin');
Route::get('auth/logout', 'Auth\AuthController@getLogout');

// Registration routes...
Route::get('auth/register', 'Auth\AuthController@getRegister');
Route::post('auth/register', 'Auth\AuthController@postRegister');

//Password forgot routes
Route::controllers([
    'password' => 'Auth\PasswordController',
]);

// Safe routes
Route::group(array('middleware' => 'auth'), function() {

    Route::resource('newWork', 'NewWorkController');
    Route::resource('user', 'UserController');
    Route::resource('club', 'ClubController');

    Route::get('proveWork', 'NewWorkController@showProveWorkActivities')->name('proveWork');
    Route::get('export', 'ClubController@export')->name('club.export');
    Route::get('mail', 'ClubController@sendMailToUsers')->name('club.mail');
    Route::get('exportPDF', 'ClubController@generateTeamPDF')->name('club.exportPDF');
    Route::put('deactivateHours', 'ClubController@setAllHoursOnInactive')->name('club.setInactive');
    Route::put('updateHours', 'NewWorkController@bisectHours')->name('newWork.bisect');
});
