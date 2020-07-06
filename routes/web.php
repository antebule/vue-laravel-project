<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

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

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/', function () {
    return view('welcome');
});


// User routes
Route::prefix('user')->group(function(){
    Route::get('/current', function(){
        return Auth::user();
    });
    
    Route::post('/thesisrequests', function(Request $request){
        return App\ThesisReservation::where('user_id', '=', $request->id)->get();
    });

    Route::get('/logout', 'Auth\LoginController@userLogout')->name('user.logout');
});

// Thesis routes
Route::prefix('thesis')->group(function(){
    Route::post('/create', 'HomeController@createThesisReservation');

    Route::post('/delete', function(Request $request){
        $thesis = App\ThesisReservation::find($request->id);
        $thesis->delete();
    });

    Route::post('/student', function(Request $request){
        return App\User::find($request->id);
    });

    Route::post('/teacher', function(Request $request){
        return App\Teacher::find($request->id);
    });
});

// Teacher routes
Route::prefix('teacher')->group(function(){
    Route::get('/login', 'Auth\TeacherLoginController@showLoginForm')->name('teacher.login');
    Route::post('/login', 'Auth\TeacherLoginController@login')->name('teacher.login.submit');
    Route::get('/', 'TeacherController@index')->name('teacher.dashboard');
    Route::get('/logout', 'Auth\TeacherLoginController@logout')->name('teacher.logout');
    Route::get('/all', function(){
        return App\Teacher::all();
    });
    Route::post('/thesisrequests', function(Request $request){
        return App\ThesisReservation::where('teacher_id', '=', $request->id)->get();
    });

    Route::get('/current', function(){
        return Auth::guard('teacher')->user();
    });

    Route::post('/thesisresponse', function(Request $request){
        $thesis = App\ThesisReservation::find($request->id);
        $thesis->status = $request->status;
        $thesis->update();
    });
});

// Admin routes
Route::prefix('admin')->group(function(){
    Route::get('/', 'AdminController@index')->name('admin.administration');
    Route::get('/login', 'Auth\AdminLoginController@showLoginForm')->name('admin.login');
    Route::post('/login', 'Auth\AdminLoginController@login')->name('admin.login.submit');
    Route::get('/logout', 'Auth\AdminLoginController@logout')->name('admin.logout');
});
