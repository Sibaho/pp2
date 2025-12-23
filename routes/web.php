<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AsetController;
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
            Route::get('/edit-user/{uuid}', 'editUser')->name('user.edit');
            Route::post('/update-user/{uuid}', 'updateUser')->name('user.update');
            Route::delete('/delete-user', 'deleteUser')->name('user.delete');
        });

        Route::controller(MonitoringController::class)->group(function () {
            Route::get('/monitoring', 'index')->name('monitoring.index');
            Route::get('/monitoring/add', 'add')->name('monitoring.add');
            Route::post('/monitoring/add', 'store')->name('monitoring.store');
            Route::get('/monitoring/edit/{uuid}', 'edit')->name('monitoring.edit');
            Route::post('/monitoring/update/{uuid}', 'update')->name('monitoring.update');
            Route::get('/monitoring/delete/{uuid}', 'delete')->name('monitoring.delete');
            Route::get('/monitoring/view/{uuid}', 'view')->name('monitoring.view');
        });

        Route::controller(AsetController::class)->group(function () {
            Route::get('/asets', 'index')->name('asets.index');
            Route::get('/asets/add', 'add')->name('asets.add');
            Route::post('/asets/add', 'store')->name('asets.store');
            Route::get('/asets/edit/{uuid}', 'edit')->name('asets.edit');
            Route::post('/asets/update/{uuid}', 'update')->name('asets.update');
            Route::get('/asets/delete/{uuid}', 'delete')->name('asets.delete');
            Route::get('/asets/view/{uuid}', 'view')->name('asets.view');
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

         Route::controller(AsetController::class)->group(function () {
            Route::get('/asets', 'index')->name('asets.index');
            Route::get('/asets/add', 'add')->name('asets.add');
            Route::post('/asets/add', 'store')->name('asets.store');
            Route::get('/asets/edit/{id}', 'edit')->name('asets.edit');
            Route::post('/asets/update/{id}', 'update')->name('asets.update');
            Route::get('/asets/delete/{id}', 'delete')->name('asets.delete');
            Route::get('/asets/view/{id}', 'view')->name('asets.view');
        });
    });
});

Route::get('/monitoring/dokumen/{uuid}', 
    [MonitoringController::class, 'downloadDokumen']
)->name('monitoring.dokumen.download');

Route::get('/monitoring/dokumen/{uuid}/preview',
    [MonitoringController::class, 'previewDokumen']
)->name('monitoring.dokumen.preview');

require __DIR__ . '/auth.php';
