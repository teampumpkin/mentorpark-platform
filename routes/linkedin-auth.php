<?php

use App\Http\Controllers\GoogleCalendarController;
use App\Http\Controllers\GoogleController;
use App\Http\Controllers\LinkedinController;
use Illuminate\Support\Facades\Route;


// LinkedIn Login Route (Button Click)
Route::get('auth/linkedin', [LinkedinController::class, 'redirectToLinkedin'])->name('linkedin.login');



Route::get('auth/linkedin/login', [LinkedinController::class, 'redirectToLinkedin'])->name('linkedin.login')->defaults('action', 'login');
Route::get('auth/linkedin/register', [LinkedinController::class, 'redirectToLinkedin'])->name('linkedin.register')->defaults('action', 'register');

Route::get('auth/linkedin/callback', [LinkedinController::class, 'handleLinkedinCallback'])->name('linkedin.callback');



// LinkedIn Callback Route
Route::get('auth/linkedin/callback', [LinkedinController::class, 'handleLinkedinCallback'])->name('linkedin.callback');

