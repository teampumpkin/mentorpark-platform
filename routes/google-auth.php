<?php

use App\Http\Controllers\GoogleCalendarController;
use App\Http\Controllers\GoogleController;
use Illuminate\Support\Facades\Route;

Route::get('/auth/google', [GoogleController::class, 'redirectToGoogle'])->name('google.login');
Route::get('/auth/google/callback', [GoogleController::class, 'handleGoogleCallback']);


Route::get('/auth/google/redirect', [GoogleCalendarController::class, 'redirectToGoogle'])->name('google.redirect');
Route::get('/auth/google/callback', [GoogleCalendarController::class, 'handleGoogleCallback'])->name('google.callback');
//Route::get('/calendar', [GoogleCalendarController::class, 'viewCalendarEvents'])->name('calendar.view');
Route::post('/calendar/event/create', [GoogleCalendarController::class, 'createGoogleCalendarEvent'])->name('calendar.event.create');
Route::get('/demo-event', [GoogleCalendarController::class, 'demoCreateEvent'])->name('demo.calendar.event.create');
