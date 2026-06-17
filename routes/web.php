<?php

use App\Http\Controllers\TicketController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome')->name('home');

Route::middleware('auth')->group(function (): void {
    Route::view('/dashboard', 'dashboard')->name('dashboard');

    Route::get('/tickets/create', [TicketController::class, 'create'])
        ->name('tickets.create');
    Route::post('/tickets', [TicketController::class, 'store'])
        ->name('tickets.store');
});

require __DIR__.'/auth.php';
