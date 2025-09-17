<?php
use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\IndicatorController;
use App\Models\Improvement;
// Tanpa perlu login
Route::get('/', function () {
     $latestIndicators = \App\Models\Indicator::latest()->take(5)->get();
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
        'latestIndicators' => $latestIndicators,
    ]);
})->name('home');

Route::get('/api/improvements', function () {
    return response()->json(Improvement::all(['id', 'name']));
});
Route::post('/feedback', [FeedbackController::class, 'store'])->name('feedback.store');
Route::get('/indicators', [IndicatorController::class, 'list'])->name('indicators.index');
Route::get('/indicators/{indicator}', [IndicatorController::class, 'show'])->name('indicators.show');

// Perlu Login
// Route::get('/dashboard', function () {
//     return Inertia::render('Dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('/indicators/{indicator}/like', [IndicatorController::class, 'like'])->name('indicators.like');
    Route::post('/indicators/{indicator}/unlike', [IndicatorController::class, 'unlike'])->name('indicators.unlike');
});
require __DIR__ . '/auth.php';