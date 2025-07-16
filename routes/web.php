<?php

use App\Http\Controllers\AbsenController;
use App\Http\Controllers\PresenceController;
use App\Http\Controllers\PresenceDetailController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('pages.index');
})->name('home');


// admin
Route::resource('presence', PresenceController::class);
Route::delete('presense-detail/{id}',[PresenceDetailController::class, 'destroy'])->name('presence.detail.destroy');
Route::get('presence/export-pdf/{id}', [PresenceDetailController::class, 'exportPdf'])->name('presence-detail.export-pdf'); 

// publik
Route::get('absen/{slug}', [AbsenController::class, 'index'])->name('absen.index');
Route::post('absen/save/{id}', [AbsenController::class, 'save'])->name('absen.save');