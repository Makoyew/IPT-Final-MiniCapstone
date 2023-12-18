<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ChargeController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\EnrollmentController;
use App\Http\Controllers\LogController;
use App\Http\Controllers\TestsEnrollmentController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::get('/', [AuthController::class, 'loginForm'])->name('loginForm');
Route::post('/', [AuthController::class, 'login'])->name('login');
Route::post('/dashboard', [AuthController::class, 'login'])->name('dashboard');

Route::get('/register', [AuthController::class, 'registerForm'])->name('registerForm');
Route::post('/register', [AuthController::class, 'register']);

Route::middleware(['auth', 'verified'])->group(function() {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::resource('users', AuthController::class);
    Route::resource('charges', ChargeController::class);
    Route::resource('courses', CourseController::class);
    Route::resource('enrollments', EnrollmentController::class);
    Route::post('/enrollments/enroll/{courseId}', [EnrollmentController::class, 'enroll']);
    Route::post('/enrollments/unenroll/{courseId}', [EnrollmentController::class, 'unenroll']);
    Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('dashboard');
    Route::get('/logs', [LogController::class, 'index'])->name('logs.index');
});


// Route::get('/sendmail', [EmailController::class, 'sendMail']);

Route::get('/send-testenrollment', [TestsEnrollmentController::class, 'sendTestNotification']);

Route::get('/verification/{user}/{token}', [AuthController::class, 'verification']);
