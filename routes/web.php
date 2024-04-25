<?php

use App\Http\Controllers\BackupController;
use App\Http\Controllers\BudgetController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ConfigurationController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\TransactionController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard');

    Route::resource('transactions', TransactionController::class)->only('store', 'update', 'destroy');

    Route::get('reports', [ReportController::class, 'index'])->name('reports.index');

    Route::resource('categories', CategoryController::class)->only('index', 'store', 'update', 'destroy');

    Route::resource('backups', BackupController::class)
        ->only('index', 'show', 'update')
        ->parameters(['backups' => 'period']);

    Route::resource('budgets', BudgetController::class)->only('index', 'store', 'destroy');

    Route::resource('profile', ProfileController::class)->only('index', 'store', 'destroy');

    Route::patch('configuration', [ConfigurationController::class, 'update'])->name('configuration.update');
});

require __DIR__.'/auth.php';
