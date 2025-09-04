<?php


use Inertia\Inertia;
use App\Helpers\JwtHelper;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\IndicatorController;

// Tanpa perlu login
Route::get('/', function () {
    //contoh 
    $token = JwtHelper::generateToken("e0d77f022c36172beafd31f743aa08e432a150e3d3df880c94ea8a7f3febcb14",11);
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
        'token' =>$token,
    ]);
});
Route::post('/feedback', [FeedbackController::class, 'store'])->name('feedback.store');
Route::get('/indicators', [IndicatorController::class, 'index'])->name('indicators.index');
Route::get('/indicators/{indicator}', [IndicatorController::class, 'show'])->name('indicators.show');


// Perlu Login
Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('/indicators/{indicator}/like', [IndicatorController::class, 'like'])->name('indicators.like');
    Route::delete('/indicators/{indicator}/unlike', [IndicatorController::class, 'unlike'])->name('indicators.unlike');
});
require __DIR__.'/auth.php';