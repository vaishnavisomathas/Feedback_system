<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\CounterController;
use App\Http\Controllers\DsDivisionController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\PermissionGroupController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.post');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
Route::get('/password/reset', [LoginController::class, 'showLinkRequestForm'])->name('password.request');


Route::get('/feedback/{division}/{counter}', [FeedbackController::class, 'show'])
    ->name('feedback.show');
Route::get('/dashboard', [HomeController::class, 'index'])
    ->name('dashboard');
Route::get('counters/create', [CounterController::class, 'create'])->name('counters.create');

Route::get('counters', [CounterController::class, 'index'])->name('counters.index');
Route::post('counters/store', [CounterController::class, 'store'])->name('counters.store');
Route::put('counters/update/{counter}', [CounterController::class, 'update'])
     ->name('counters.update');
Route::delete('counters/delete/{counter}', [CounterController::class, 'destroy'])->name('counters.destroy');
Route::get('/admin/feedbacks', [CounterController::class, 'feedback_index'])
    ->name('admin.feedback.index');
Route::get('/admin/feedbacks/pdf', [CounterController::class, 'downloadPdf'])
    ->name('admin.feedback.downloadPdf');    
    Route::get('ds-divisions', [DsDivisionController::class, 'index'])->name('ds-divisions.index');
  // Show QR page
    Route::get('/{counterId}/qr', [DsDivisionController::class, 'showQr'])->name('showQr');

    // Generate QR (optional, if you want a POST method to generate)

Route::post('/ds-divisions/generate-qr', [DsDivisionController::class, 'generateQr'])
    ->name('generateQr');
    // Download QR as PDF
    Route::get('/ds-divisions/{counterId}/download-qr-pdf', [DsDivisionController::class, 'downloadQrPdf'])
     ->name('ds-divisions.downloadQrPdf');

    Route::get('/{counterId}/download-qr', [DsDivisionController::class, 'downloadQr'])->name('downloadQr');
Route::get('ds-divisions/{counterId}/download-qr', [DsDivisionController::class, 'downloadQr'])
    ->name('admin.ds-divisions.qr-pdf');

        Route::post('feedback/store', [FeedbackController::class, 'store']) ->name('feedback.store');

        Route::get('/users', [UserController::class, 'index'])->name('users.index');
Route::post('/users/store', [UserController::class, 'store'])->name('users.store');
Route::put('/users/update/{id}', [UserController::class, 'update'])->name('users.update');
Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('users.destroy');

// Route::prefix('admin')->group(function () {

    // Permission Groups
    Route::get('/permission-groups', [PermissionGroupController::class,'index'])->name('permission.groups');
    Route::post('/permission-groups', [PermissionGroupController::class,'store'])->name('permission.groups.store');
    Route::put('/admin/permission-groups/{id}', [PermissionGroupController::class,'update'])->name('permission.groups.update');
    Route::delete('/permission-groups/{id}', [PermissionGroupController::class,'destroy'])->name('permission.groups.delete');

    // Permissions
    Route::get('/permissions', [PermissionController::class,'index'])->name('permissions.index');
    Route::post('/permissions', [PermissionController::class,'store'])->name('permissions.store');
    Route::put('/admin/permissions/{id}', [PermissionController::class,'update'])->name('permissions.update');
    Route::delete('/permissions/{id}', [PermissionController::class,'destroy'])->name('permissions.delete');

    // Roles
    Route::get('/roles', [RoleController::class,'index'])->name('roles.index');
    Route::post('/roles', [RoleController::class,'store'])->name('roles.store');
    Route::put('/admin/roles/{id}', [RoleController::class,'update'])->name('roles.update');
    Route::delete('/roles/{id}', [RoleController::class,'destroy'])->name('roles.delete');

// });