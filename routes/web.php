<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\StudentController;

Route::middleware('guest')->group(function () {
	Route::get('/', [AuthController::class, 'showLogin'])->name('login');
	Route::get('/login', [AuthController::class, 'showLogin']);
	Route::post('/login', [AuthController::class, 'login'])->name('login.store');
	Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
	Route::post('/register', [AuthController::class, 'register'])->name('register.store');
	Route::get('/forgot-password', [AuthController::class, 'showForgotPassword'])->name('password.request');
	Route::post('/forgot-password', [AuthController::class, 'sendResetLink'])->name('password.email');
	Route::get('/reset-password/{token}', [AuthController::class, 'showResetPassword'])->name('password.reset');
	Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.update');
});

Route::get('/scan/{id}', [StudentController::class, 'scan'])->name('students.scan');
Route::get('/scan/{id}/documents/{document}', [StudentController::class, 'downloadDocument'])->name('students.scan.document');

Route::middleware('auth')->group(function () {
	Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
	Route::get('/dashboard', [StudentController::class, 'index'])->name('dashboard');
	Route::get('/home', fn () => redirect()->route('dashboard'));
	Route::get('/create', [StudentController::class, 'create'])->name('students.create');
	Route::post('/store', [StudentController::class, 'store'])->name('students.store');
	Route::get('/student/{id}/edit', [StudentController::class, 'edit'])->name('students.edit');
	Route::put('/student/{id}', [StudentController::class, 'update'])->name('students.update');
	Route::post('/verify/{id}', [StudentController::class, 'verify'])->name('students.verify');
	Route::post('/graduate/{id}', [StudentController::class, 'graduate'])->name('students.graduate');
	Route::get('/students/export/graduates', [StudentController::class, 'exportGraduates'])->name('students.export.graduates');
	Route::get('/student/{id}/qrcode', [StudentController::class, 'showQr'])->name('student.qrcode');
	Route::get('/student/{id}/documents/{document}', [StudentController::class, 'downloadDocument'])->name('students.document');
});