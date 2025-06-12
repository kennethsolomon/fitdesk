<?php

declare(strict_types=1);

use App\Http\Controllers\MemberController;
use App\Http\Controllers\SubscriptionController;
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
    Route::group(['prefix' => 'members'], function () {
        Route::get('/', [MemberController::class, 'index'])
            ->name('members.index');
        Route::post('/', [MemberController::class, 'store'])
            ->name('members.store');
        Route::post('/{member}', [MemberController::class, 'update'])
            ->name('members.update');
        Route::delete('/{member}', [MemberController::class, 'destroy'])
            ->name('members.destroy');
    });

    Route::group(['prefix' => 'subscriptions'], function () {
        Route::get('/', [SubscriptionController::class, 'index'])
            ->name('subscriptions.index');

        Route::post('/members/{member}', [SubscriptionController::class, 'store'])
            ->name('members.subscription.store');
    });

});
