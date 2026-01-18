<?php
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UrlController;
use App\Http\Controllers\InvitationController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    // URL Management - ONLY admin/mamber can create
    Route::middleware('role:admin,mamber')->group(function () {
        Route::get('/urls/create', [UrlController::class, 'create'])->name('urls.create');
        Route::post('/urls', [UrlController::class, 'store'])->name('urls.store');
    });
    
    // URL Listing - Role-based access
    Route::get('/urls', [UrlController::class, 'index'])->name('urls.index');
    
    // Invitations - SuperAdmin/Admin only
    Route::middleware('role:superadmin,admin')->group(function () {
        Route::get('/invitations', [InvitationController::class, 'index'])->name('invitations.index');
        Route::get('/invitations/create', [InvitationController::class, 'create'])->name('invitations.create');
        Route::post('/invitations', [InvitationController::class, 'store'])->name('invitations.store');
    });
});

require __DIR__.'/auth.php';

// Public URL resolution (NO AUTH REQUIRED)
Route::get('{short_code}', [UrlController::class, 'redirect'])
    ->where('short_code', '[A-Za-z0-9]+');
