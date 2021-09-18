<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CityController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\SpecialityController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\ThemeController;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\StudentCoursesController;
use App\Http\Controllers\FileController;

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

Route::get('/storage/{file_name}', FileController::class)->where(['file_name' => '.*'])->middleware(['auth']);

Route::group(['middleware' => ['auth', 'role:administrator']], function() {
    Route::resource('cities', CityController::class)->except([
        'show', 'create'
    ]);

    Route::resource('specialities', SpecialityController::class)->except([
        'show', 'create'
    ]);

    Route::resource('teachers', TeacherController::class)->except([
        'show', 'create'
    ]);
    Route::post('/teachers/{teacher}/updateletter', [TeacherController::class, 'updateLetter'])->name('teachers.updateLetter');
    
});

Route::group(['middleware' => ['auth', 'role:teacher']], function() {
    Route::resource('students', StudentController::class)->except([
        'show', 'create'
    ]);
    Route::post('students/{student}/updateletter', [StudentController::class, 'updateLetter'])->name('students.updateLetter');

    Route::resource('students/groups', GroupController::class)->except([
        'show', 'create'
    ]);
    Route::post('groups/{group}/{student}/ungroup', [GroupController::class, 'ungroup'])->name('groups.ungroup.student');

    Route::resource('courses', CourseController::class)->except([
        'show', 'create'
    ]);
    Route::resource('courses/themes', ThemeController::class)->except([
        'index', 'show', 'create'
    ]);
    Route::resource('courses/materials', MaterialController::class)->except([
        'create', 'index', 'show', 'store'
    ]);

    Route::get('courses/{course}/{theme}/{material_type_id}/materials/create', [MaterialController::class, 'create'])->name('materials.create');
    Route::post('courses/{course}/{theme}/{material_type_id}/materials/store', [MaterialController::class, 'store'])->name('materials.store');
});

Route::get('/lk', function () {
    return view('auth.login');
});

Route::group(['prefix' => 'lk', 'middleware' => ['auth', 'role:student']], function() {
    Route::get('courses', [StudentCoursesController::class, 'index'])->name('student.courses.index');
    Route::get('courses/{course}', [StudentCoursesController::class, 'show'])->name('student.courses.show');

    Route::post('courses/{course}/material/{material}/start', [StudentCoursesController::class, 'startMaterial'])->name('student.materials.start');
    Route::post('courses/{course}/material/{material}/finish', [StudentCoursesController::class, 'finishMaterial'])->name('student.materials.finish');
    Route::get('courses/{course}/material/{material}', [StudentCoursesController::class, 'showMaterial'])->name('student.materials.show');
});


Route::group(['prefix' => 'laravel-filemanager', 'middleware' => ['auth', 'role:teacher']], function () {
    \UniSharp\LaravelFilemanager\Lfm::routes();
});

//Один роут для нескольких ролей. Но нужно закомментить строки в RoleMiddleware
// Route::group(['middleware' => 'role:administrator,teacher'], function() {
//     Route::resource('students', StudentController::class)->except([
//         'show', 'create'
//     ]);
//     Route::post('students/{student}/updateletter', [StudentController::class, 'updateLetter'])->name('students.updateLetter');
// });

require __DIR__.'/auth.php';
