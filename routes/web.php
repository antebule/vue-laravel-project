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

Route::get('/', function () {
    return view('welcome');
});

Route::get('user/current', function(){
    return Auth::user();
});

Route::post('user/thesisrequests', function(Request $request){
    return App\ThesisReservation::where('user_id', '=', $request->id)->get();
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/users/logout', 'Auth\LoginController@userLogout')->name('user.logout');

Route::post('thesis/create', 'HomeController@createThesisReservation');

Route::post('thesis/student', function(Request $request){
    return App\User::find($request->id);
});

Route::post('thesis/teacher', function(Request $request){
    return App\Teacher::find($request->id);
});

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
