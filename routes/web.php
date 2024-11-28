<?php

use App\Http\Livewire\ActivityTracker;
use App\Models\Activity;

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
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/activities', ActivityTracker::class)->name('activities.index');
});

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/activities/custom-print', function (Request $request) {
    $request->validate([
        'start_date' => 'required|date',
        'end_date' => 'required|date|after_or_equal:start_date',
    ]);

    $activities = Activity::whereBetween('date', [$request->start_date, $request->end_date])
        ->orderBy('date', 'desc')
        ->get();

    return view('activities.custom-print', [
        'activities' => $activities,
        'start_date' => $request->start_date,
        'end_date' => $request->end_date,
    ]);
})->name('activities.custom-print');
