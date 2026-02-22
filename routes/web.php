<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ComplaintController;
use App\Http\Controllers\ComplainTypeController;
use App\Http\Controllers\CounterController;
use App\Http\Controllers\DsDivisionController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\PermissionGroupController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\ServiceQualityController;
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
Route::get('/', [AuthController::class,'showLogin'])->name('login');
Route::post('/login', [AuthController::class,'login'])->name('login.post');
Route::post('/logout', [AuthController::class,'logout'])->name('logout');


Route::get('/feedback/{division}/{counter}', [FeedbackController::class, 'show'])
    ->name('feedback.show');
     Route::post('feedback/store', [FeedbackController::class, 'store']) ->name('feedback.store');
        Route::view('/thank-you','thankyou')->name('feedback.thankyou');
Route::view('/closed','closed')->name('feedback.closed');
Route::middleware('auth')->group(function () {
Route::post('/admin/feedback/forward/{id}', [FeedbackController::class, 'forwardFeedback'])->name('admin.feedback.forward');

Route::post('/admin/feedback/{feedback}/forward', [FeedbackController::class, 'forwardFeedback'])
    ->name('admin.feedback.forward');


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

       

        Route::resource('users', UserController::class);
        
Route::resource('roles', RoleController::class);
Route::resource('permissions', PermissionController::class);
Route::resource('permission-groups', PermissionGroupController::class);

Route::get('/admin/complaints', [ComplaintController::class, 'index'])
    ->name('admin.complain.index');
Route::post('/admin/complaints/{id}/remarks',[ComplaintController::class,'saveuserRemarks']
)->name('admin.complain.remarks');

Route::get('/admin/complaints',[ComplaintController::class,'index'])->name('admin.complain.index');
Route::post('/admin/complaints/{id}/forward',[ComplaintController::class,'forward'])->name('admin.complain.forward');

Route::get('/admin/ao-complaints',[ComplaintController::class,'aoIndex'])->name('admin.ao.index');
Route::get('/admin/ao',[ComplaintController::class,'aoIndex'])->name('admin.ao.index');
Route::post('/admin/ao-save/{id}',[ComplaintController::class,'aoSave'])->name('admin.ao.save');

Route::get('/commissioner/complaints',[ComplaintController::class,'commissionerIndex'])->name('admin.commissioner.index');
Route::post('/commissioner/close/{id}',[ComplaintController::class,'commissionerClose'])->name('admin.commissioner.close');

//complain type
Route::get('/complain-types',[ComplainTypeController::class,'index'])->name('complain.types.index');
Route::post('/complain-types',[ComplainTypeController::class,'store'])->name('complain.types.store');
Route::put('/complain-types/{id}',[ComplainTypeController::class,'update'])->name('complain.types.update');
Route::delete('/complain-types/{id}',[ComplainTypeController::class,'destroy'])->name('complain.types.destroy');

Route::get('/service-quality',[ServiceQualityController::class,'index'])->name('service.quality.index');
Route::post('/service-quality',[ServiceQualityController::class,'store'])->name('service.quality.store');
Route::put('/service-quality/{id}',[ServiceQualityController::class,'update'])->name('service.quality.update');
Route::delete('/service-quality/{id}',[ServiceQualityController::class,'destroy'])->name('service.quality.destroy');
});