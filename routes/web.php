<?php

use App\Http\Controllers\Admin\ResumeDownloadController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\PageController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [PageController::class, 'about'])->name('about');
Route::get('/services', [PageController::class, 'services'])->name('services');
Route::get('/privacy', [PageController::class, 'privacy'])->name('privacy');

Route::get('/jobs', [JobController::class, 'index'])->name('jobs.index');
Route::get('/jobs/{job:slug}', [JobController::class, 'show'])->name('jobs.show');
Route::post('/jobs/{job:slug}/apply', [JobController::class, 'apply'])
    ->middleware('throttle:10,60')
    ->name('jobs.apply');

Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::post('/contact', [ContactController::class, 'store'])
    ->middleware('throttle:6,60')
    ->name('contact.store');

Route::post('/chat', [ChatController::class, 'reply'])->middleware('throttle:40,60')->name('chat.reply');

// Candidate auth
Route::middleware('guest')->group(function () {
    Route::get('/register', [RegisterController::class, 'create'])->name('register');
    Route::post('/register', [RegisterController::class, 'store'])
        ->middleware('throttle:5,60');
    Route::get('/login', [LoginController::class, 'create'])->name('login');
    Route::post('/login', [LoginController::class, 'store'])
        ->middleware('throttle:10,15')
        ->name('login.store');
});
Route::post('/logout', [LoginController::class, 'destroy'])->middleware('auth')->name('logout');

// Candidate account
Route::middleware(['auth', 'candidate'])->group(function () {
    Route::get('/account', [AccountController::class, 'edit'])->name('account.edit');
    Route::post('/account', [AccountController::class, 'update'])->name('account.update');
    Route::get('/account/resume', [AccountController::class, 'downloadResume'])->name('account.resume');
});

// Secure resume downloads for admins (outside the Filament panel, reused by table actions)
Route::middleware(['auth', 'admin'])->prefix('admin-files')->group(function () {
    Route::get('/applications/{application}/resume', [ResumeDownloadController::class, 'application'])->name('admin.resume.application');
    Route::get('/candidates/{candidate}/resume', [ResumeDownloadController::class, 'candidate'])->name('admin.resume.candidate');
    Route::get('/contact-messages/{contactMessage}/resume', [ResumeDownloadController::class, 'contactMessage'])->name('admin.resume.contact');
});
