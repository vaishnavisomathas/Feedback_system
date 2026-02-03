<?php

use App\Http\Controllers\CounterController;
use App\Http\Controllers\DsDivisionController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\HomeController;
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

Route::get('/feedback/{division}/{counter}', [FeedbackController::class, 'show'])
    ->name('feedback.show');
Route::get('/', [HomeController::class, 'index'])
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