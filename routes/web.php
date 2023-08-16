<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\InvoicesController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SectionController;
use App\Http\Controllers\InvoicesDetailsController;
use App\Http\Controllers\InvoicesAttachmentsController;

use Illuminate\Support\Facades\Auth; // Import the DB facade

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

Route::get('/', function () {
    return view('auth.login');
});
// Route::get('/{page}', 'AdminController@index');



Auth::routes();

Route::resource('invoices', InvoicesController::class);
Route::resource('sections', SectionController::class);
Route::resource('products', ProductController::class);
Route::resource('invoices', InvoicesController::class);
Route::get('/section/{id}', [InvoicesController::class, 'getproducts']);
Route::get('/invoice-details/{id}', [InvoicesDetailsController::class, 'index'])->name('invoice.details');
Route::get('attachments/{file_name}', 'InvoicesDetailsController@openFile')->name('attachments');
Route::get('download/{file_name}', 'InvoicesDetailsController@get_file');
Route::post('delete_file', [InvoicesDetailsController::class,'destroy'])->name('delete_file');
Route::post('update-invoice', [InvoicesController::class,'update']);
Route::get('delete-invoice/{id}', [InvoicesController::class,'destroy']);

Route::post('add-attachment', [InvoicesAttachmentsController::class,'addAttachment']);


Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/{page}', [AdminController::class, 'index']);
