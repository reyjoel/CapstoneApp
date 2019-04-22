<?php
use App\Guardian;

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

// Admin
Route::prefix('admin')->group(function() {
    Route::get('/login', 'AdminAuth\LoginController@showLoginForm')->name('admin.login');
    Route::post('/login', 'AdminAuth\LoginController@login')->name('admin.login.submit');
});
Route::group(['prefix' => 'admin', 'middleware' => ['auth:web_admin']], function(){
    Route::get('/home', 'AdminController@index')->name('admin.home');
    Route::get('/profile', 'AdminController@linkProfile');
    Route::put('/updateinfo', 'AdminController@updateInfo');
    Route::put('/updateemail', 'AdminController@updateEmail');
    Route::put('/updatepassword', 'AdminController@updatePassword');
    // Student
    Route::get('/stutable', 'AdminController@studentTable');
    Route::get('/showstutable', 'AdminController@showStudentTable');
    Route::post('/addstudent', 'AdminController@addStudentTable');
    Route::put('/updatestudent', 'AdminController@updateStudentTable');
    Route::post('/deletestudent', 'AdminController@deleteStudentTable');
    // Driver
    Route::get('/dritable', 'AdminController@driverTable');
    Route::get('/showdritable', 'AdminController@showDriverTable');
    Route::post('/adddriver', 'AdminController@addDriverTable');
    Route::put('/updatedriver', 'AdminController@updateDriverTable');
    Route::post('/deletedriver', 'AdminController@deleteDriverTable');
    Route::get('/logout', 'AdminController@logout');
    // Guardian
    Route::get('/guatable', 'AdminController@guardianTable');
    Route::get('/showguatable', 'AdminController@showGuardianTable');
    Route::post('/addguardian', 'AdminController@addGuardianTable');
    Route::put('/updateguardian', 'AdminController@updateGuardianTable');
    Route::post('/deleteguardian', 'AdminController@deleteGuardianTable');
    Route::get('/logout', 'AdminController@logout');
    // Bus
    Route::get('/bustable', 'AdminController@busTable');
    Route::get('/showbustable', 'AdminController@showBusTable');
    Route::post('/addbus', 'AdminController@addBusTable');
    Route::put('/updatebus', 'AdminController@updateBusTable');
    Route::post('/deletebus', 'AdminController@deleteBusTable');
    Route::get('/logout', 'AdminController@logout');
});

// Student
Route::prefix('student')->group(function() {
    Route::get('/login', 'StudentAuth\LoginController@showLoginForm')->name('student.login');
    Route::post('/login', 'StudentAuth\LoginController@login')->name('student.login.submit');
});
Route::group(['prefix' => 'student', 'middleware' => ['auth:web_student']], function(){
    Route::get('/home', 'StudentController@index')->name('student.home');
    Route::post('/home', 'StudentController@updateLocation');
    Route::get('/home/studentinfo', 'StudentController@showInformation');
    Route::get('/home/showlocation', 'StudentController@showLocation');
    Route::get('/profile', 'StudentController@linkProfile');
    Route::put('/updateinfo', 'StudentController@updateInfo');
    Route::put('/updateemail', 'StudentController@updateEmail');
    Route::put('/updatepassword', 'StudentController@updatePassword');
    Route::get('/driver/message', 'StudentController@linkMessage');
    Route::post('/driver/message', 'MessageController@sendStudentMessages');
    Route::get('/driver/message/recieve', 'MessageController@fetchStudentMessages');
    Route::get('/driver', 'StudentController@linkDriver');
    Route::get('/driver/driverinfo', 'StudentController@showDriverInfo');
    Route::get('/logout', 'StudentController@logout');

    //for notifications
    Route::get('/notification', 'StudentController@studentNotifications');
    Route::get('/studentNotifications', 'NotificationController@studentNotifications');
});

// Driver
Route::prefix('driver')->group(function() {
    Route::get('/login', 'DriverAuth\LoginController@showLoginForm')->name('driver.login');
    Route::post('/login', 'DriverAuth\LoginController@login')->name('driver.login.submit');
});
Route::group(['prefix' => 'driver', 'middleware' => ['auth:web_driver']], function(){
    Route::get('/home', 'DriverController@index')->name('driver.home');
    Route::post('/home', 'DriverController@updateLocation');
    Route::get('/profile', 'DriverController@linkProfile');
    Route::put('/updateinfo', 'DriverController@updateInfo');
    Route::put('/updateemail', 'DriverController@updateEmail');
    Route::put('/updatepassword', 'DriverController@updatePassword');
    Route::get('/student/message', 'DriverController@linkMessage');
    Route::post('/student/message', 'MessageController@sendDriverMessages');
    Route::get('/student/message/recieve', 'MessageController@fetchDriverMessages');
    Route::get('/logout', 'DriverController@logout');

    //for notifications
    Route::get('/notification', 'DriverController@driverNotifications');
    Route::get('/driverNotifications', 'NotificationController@driverNotifications');
    Route::post('/notifyAll', 'NotificationController@notifyAll');
});

// Guardian
Route::prefix('guardian')->group(function() {
    Route::get('/login', 'GuardianAuth\LoginController@showLoginForm')->name('guardian.login');
    Route::post('/login', 'GuardianAuth\LoginController@login')->name('guardian.login.submit');
});
Route::group(['prefix' => 'guardian', 'middleware' => ['auth:web_guardian']], function(){
    Route::get('/home', 'GuardianController@index')->name('guardian.home');
    Route::get('/home/showlocation', 'GuardianController@showLocation');
    Route::get('/profile', 'GuardianController@linkProfile');
    Route::get('/profile/showinfo', 'GuardianController@showProfileInfo');
    Route::put('/updateinfo', 'GuardianController@updateInfo');
    Route::put('/updateemail', 'GuardianController@updateEmail');
    Route::put('/updatepassword', 'GuardianController@updatePassword');
    Route::get('/logout', 'GuardianController@logout');

    //for notifications
    Route::get('/notification', 'GuardianController@guardianNotifications');
    Route::get('/guardianNotifications', 'NotificationController@guardianNotifications');
    Route::post('/notifyDriver', 'NotificationController@notifyDriver');
});
