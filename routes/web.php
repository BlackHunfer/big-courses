<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CityController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\SpecialityController;
use App\Http\Controllers\GroupController;
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

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::group(['middleware' => 'role:administrator'], function() {
    Route::resource('cities', CityController::class)->except([
        'show', 'create'
    ]);
    Route::resource('teachers', TeacherController::class)->except([
        'show', 'create'
    ]);
    Route::post('/teachers/{teacher}/updateletter', [TeacherController::class, 'updateLetter'])->name('teachers.updateLetter');
    
});

Route::group(['middleware' => 'role:teacher'], function() {
    Route::resource('students', StudentController::class)->except([
        'show', 'create'
    ]);
    Route::post('students/{student}/updateletter', [StudentController::class, 'updateLetter'])->name('students.updateLetter');

    Route::resource('specialities', SpecialityController::class)->except([
        'show', 'create'
    ]);

    Route::resource('groups', GroupController::class)->except([
        'show', 'create'
    ]);
    Route::post('groups/{group}/{student}/ungroup', [GroupController::class, 'ungroup'])->name('groups.ungroup.student');
});


//Один роут для нескольких ролей. Но нужно закомментить строки в RoleMiddleware
// Route::group(['middleware' => 'role:administrator,teacher'], function() {
//     Route::resource('students', StudentController::class)->except([
//         'show', 'create'
//     ]);
//     Route::post('students/{student}/updateletter', [StudentController::class, 'updateLetter'])->name('students.updateLetter');
// });

require __DIR__.'/auth.php';
