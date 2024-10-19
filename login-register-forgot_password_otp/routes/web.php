<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

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

// Controller Đăng ký tài khoản có OTP
use App\Http\Controllers\Auth\RegisterOTPController;
// Controller quên mật khẩu tài khoản gửi mã otp về gmail
use App\Http\Controllers\Auth\ForgotPasswordController;






Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';


//Register OTP
Route::get('/register', [RegisterOTPController::class, 'showRegistrationForm'])->name('auth.register');
Route::post('/register', [RegisterOTPController::class, 'register'])->name('auth.register');
// Route hiển thị form nhập mã OTP
Route::get('/otp/auth.verify', [RegisterOTPController::class, 'showOtpForm'])->name('auth.verify.otp');

// Route để xử lý việc xác minh OTP
Route::post('/otp', [RegisterOTPController::class, 'verifyOtp'])->name('auth.verify.otp.post');
// Route để xử lý gửi lại OTP
Route::post('/resend-otp', [RegisterOTPController::class, 'resendOtp'])->name('auth.resend.otp');


// Route cho trang quên mật khẩu
Route::get('/auth/otp', [ForgotPasswordController::class, 'showOtpForm'])->name('auth.otp');
Route::get('/forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])
    ->name('password.request');
Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])
    ->name('password.email');

// Route cho trang nhập mã OTP
Route::get('/auth/reset-password', [ForgotPasswordController::class, 'showResetForm'])
    ->name('password.reset');
Route::post('/check-otp', [ForgotPasswordController::class, 'checkOtp'])
    ->name('password.checkOtp');

// Route cho trang đặt lại mật khẩu
Route::post('/auth/reset-password', [ForgotPasswordController::class, 'update'])
    ->name('password.updated');