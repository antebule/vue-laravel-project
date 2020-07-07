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

    Route::get('/all', function(){
        return App\User::all();
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
    Route::post('/deleteTeacher', function(Request $request){
        $teacher = App\Teacher::find($request->id);
        $teacher->delete();
        return $request;
    });
    
    Route::post('/deleteStudent', function(Request $request){
        $user = App\User::find($request->id);        
        $user->delete();
        return $request;
    });

    Route::post('/editstudent', function(Request $request){
        $user = App\User::find($request->id);
        $user->firstName = $request->firstName;
        $user->lastName = $request->lastName;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->indexNumber = $request->indexNumber;
        $user->collegeMajor = $request->collegeMajor;
        $user->studyYear = $request->studyYear;        
        $user->update();
        return $user;
    });

    Route::post('/editteacher', function(Request $request){
        $teacher = App\Teacher::find($request->id);
        $teacher->firstName = $request->firstName;
        $teacher->lastName = $request->lastName;
        $teacher->email = $request->email;
        $teacher->password = Hash::make($request->password);      
        $teacher->update();
        return $teacher;
    });

    Route::post('/addstudent', function(Request $request){
        $student = new App\User;
        $student->firstName = $request->firstName;
        $student->lastName = $request->lastName;
        $student->email = $request->email;
        $student->password = Hash::make($request->password);
        $student->indexNumber = $request->indexNumber;
        $student->collegeMajor = $request->collegeMajor;
        $student->studyYear = $request->studyYear;
        $student->save();
        return $student;
    });

    Route::post('/addteacher', function(Request $request){
        $teacher = new App\Teacher;
        $teacher->firstName = $request->firstName;
        $teacher->lastName = $request->lastName;
        $teacher->email = $request->email;
        $teacher->password = Hash::make($request->password);
        $teacher->save();
        return $teacher;
    });
});
