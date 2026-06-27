<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ReportsController;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/reports', [ReportsController::class, 'index'])->name('reports.index');

Route::post('/reports/submit', [ReportsController::class, 'submit'])->name('reports.submit');
// from branch api/file 
