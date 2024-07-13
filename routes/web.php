<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CustomerReportController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InvoiceAttachmentsController;
use App\Http\Controllers\InvoicesArchiveController;
use App\Http\Controllers\InvoicesController;
use App\Http\Controllers\InvoicesDetailsController;
use App\Http\Controllers\InvoicesReportController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SectionsController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Authentication
// Auth::routes();
Auth::routes(['register' => false]);
Route::get('/', function () {
    return view('auth.login');
});


// Home
Route::get('/home', [HomeController::class, 'index'])->name('home');

// Invoices
Route::resource('/invoices', InvoicesController::class);
Route::get('/invoice/details/{id}', [InvoicesDetailsController::class, 'index']);
Route::get('/invoice/details/{id}/{is_archive}', [InvoicesDetailsController::class, 'index']);

Route::get('/status_show/{id}', [InvoicesController::class, 'show'])->name('status_show');
Route::patch('/status_update/{id}', [InvoicesController::class, 'status_update'])->name('status_update');

Route::get('/invoice_print/{id}', [InvoicesController::class, 'invoice_print'])->name('invoice_print');

// Reports
Route::get('invoices_report', [InvoicesReportController::class, 'index']);
Route::post('search_invoices', [InvoicesReportController::class, 'search_invoices']);


Route::get('customers_report', [CustomerReportController::class, 'index']);
Route::post('search_customers', [CustomerReportController::class, 'search_customers']);

// Export Excel
Route::get('/invoices_export', [InvoicesController::class, 'export'])->name('invoices_export');

// Invoices Archive
Route::resource('/archive', InvoicesArchiveController::class);

// Notification Invoices
Route::get('MarkAsRead_all', [InvoicesController::class, 'MarkAsRead_all'])->name('MarkAsRead_all');

// Invoices ( Paid , UnPaid, Partial )
Route::get('invoice_paid', [InvoicesController::class, 'invoice_paid'])->name('invoice_paid');
Route::get('invoice_unpaid', [InvoicesController::class, 'invoice_unpaid'])->name('invoice_unpaid');
Route::get('invoice_partial', [InvoicesController::class, 'invoice_partial'])->name('invoice_partial');

// Attachments
Route::resource('/InvoiceAttachments', InvoiceAttachmentsController::class);

// Sections
Route::resource('/sections', SectionsController::class);
Route::get('/section/{id}', [InvoicesController::class, 'getProducts']);

// Products
Route::resource('/products', ProductsController::class);

// Files
Route::get('/view_file/{invoice_number}/{file_name}', [InvoicesDetailsController::class, 'open_file']);
Route::get('/download_file/{invoice_number}/{file_name}', [InvoicesDetailsController::class, 'download_file']);
Route::delete('/delete_file', [InvoicesDetailsController::class, 'destroy'])->name('delete_file');

// Route::delete('user/destroy/{id}', [UserController::class, 'destroy']);

// Roles And Permissions
Route::group(['middleware' => ['auth']], function() {
    Route::resource('roles', RoleController::class);
    Route::resource('users', UserController::class);
});

Route::get('/{page}', [AdminController::class, 'index']);