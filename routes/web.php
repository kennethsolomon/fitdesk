<?php

declare(strict_types=1);

use App\Http\Controllers\MemberController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');

Route::get('dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';

Route::group(['middleware' => ['auth', 'verified']], function () {
    Route::get('/members', [MemberController::class, 'index'])
        ->name('members.index');

    Route::post('/members', [MemberController::class, 'store'])
        ->name('members.store');

    Route::post('/members/{member}', [MemberController::class, 'update'])
        ->name('members.update');

    Route::delete('/members/{member}', [MemberController::class, 'destroy'])
        ->name('members.destroy');
});
