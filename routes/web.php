<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\MonitoringController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Timpp2Controller;
use Illuminate\Contracts\Queue\Monitor;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::prefix('admin')->name('admin.')->group(function () {
    // Public admin routes (not protected by 'admin' middleware)
    Route::get('/login', [AdminController::class, 'login'])->name('login');
    Route::post('/login', [AdminController::class, 'authenticate'])->name('login.authenticate');

    // Protected admin routes
    Route::middleware('admin')->group(function () {
        Route::controller(AdminController::class)->group(function () {
            Route::get('/dashboard', 'dashboard')->name('dashboard');
            Route::get('/profile', 'profile')->name('profile');
            Route::get('/logout', 'logout')->name('logout');
        });
    });
});

Route::prefix('admin')->name('admin.')->group(function () {
    // Public admin routes (not protected by 'admin' middleware)
    Route::get('/login', [AdminController::class, 'login'])->name('login');
    Route::post('/login', [AdminController::class, 'authenticate'])->name('login.authenticate');

    // Protected admin routes
    Route::middleware('admin')->group(function () {
        Route::controller(AdminController::class)->group(function () {
            Route::get('/dashboard', 'dashboard')->name('dashboard');
            Route::get('/profile', 'profile')->name('profile');
            Route::get('/logout', 'logout')->name('logout');
            Route::get('/view-users', 'viewUsers')->name('view.users');
            Route::get('/add-user', 'addUser')->name('user.add');
            Route::post('/add-user', 'storeUser')->name('user.store');
            Route::get('/edit-user/{id}', 'editUser')->name('user.edit');
            Route::post('/update-user/{id}', 'updateUser')->name('user.update');
            Route::delete('/delete-user', 'deleteUser')->name('user.delete');
        });

        Route::controller(MonitoringController::class)->group(function () {
            Route::get('/monitoring', 'index')->name('monitoring.index');
            Route::get('/monitoring/add', 'add')->name('monitoring.add');
            Route::post('/monitoring/add', 'store')->name('monitoring.store');
            Route::get('/monitoring/edit/{id}', 'edit')->name('monitoring.edit');
            Route::post('/monitoring/update/{id}', 'update')->name('monitoring.update');
            Route::get('/monitoring/delete/{id}', 'delete')->name('monitoring.delete');
            Route::get('/monitoring/view/{id}', 'view')->name('monitoring.view');
        });
    });
});

Route::prefix('timpp2')->name('timpp2.')->group(function () {
    // Public timpp2 routes (not protected by 'timpp2' middleware)
    Route::get('/login', [Timpp2Controller::class, 'login'])->name('login');
    Route::post('/login', [Timpp2Controller::class, 'authenticate'])->name('login.authenticate');

    // Protected timpp2 routes
    Route::middleware('timpp2')->group(function () {
        Route::controller(Timpp2Controller::class)->group(function () {
            Route::get('/dashboard', 'dashboard')->name('dashboard');
            Route::get('/profile', 'profile')->name('profile');
            Route::get('/logout', 'logout')->name('logout');
        });

        Route::controller(MonitoringController::class)->group(function () {
            Route::get('/monitoring', 'index')->name('monitoring.index');
            Route::get('/monitoring/add', 'add')->name('monitoring.add');
            Route::post('/monitoring/add', 'store')->name('monitoring.store');
            Route::get('/monitoring/edit/{id}', 'edit')->name('monitoring.edit');
            Route::post('/monitoring/update/{id}', 'update')->name('monitoring.update');
            Route::get('/monitoring/delete/{id}', 'delete')->name('monitoring.delete');
            Route::get('/monitoring/view/{id}', 'view')->name('monitoring.view');
        });
    });
});

require __DIR__ . '/auth.php';
