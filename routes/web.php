<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\CourseController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Teacher\AssignmentController;
use App\Http\Controllers\Student\StudentCourseController;
use App\Http\Controllers\SupportRequestController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Rutas Públicas e Institucionales
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    if (auth()->check()) {
        return redirect()->route('dashboard');
    }
    return view('welcome');
})->name('home');

// Solicitud pública de restablecimiento de contraseña / soporte
Route::post('/solicitud-restablecimiento', [SupportRequestController::class, 'store'])
    ->name('password.support.request');

/*
|--------------------------------------------------------------------------
| Enrutamiento Centralizado del Dashboard (Según Rol)
|--------------------------------------------------------------------------
*/

Route::get('/dashboard', function () {
    $role = auth()->user()->role;

    return match ($role) {
        'administrador' => redirect()->route('admin.users.index'),
        'docente'       => redirect()->route('teacher.dashboard'),
        'alumno'        => redirect()->route('student.dashboard'),
        default         => abort(403, 'Rol no autorizado en el campus virtual.'),
    };
})->middleware(['auth', 'verified'])->name('dashboard');

/*
|--------------------------------------------------------------------------
| Perfil de Usuario (Común a todos los autenticados)
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

/*
|--------------------------------------------------------------------------
| Panel de Administración (Role: administrador)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:administrador'])->prefix('admin')->name('admin.')->group(function () {
    
    // Configuración visual y de marca
    Route::get('/settings', [SettingController::class, 'edit'])->name('settings.edit');
    Route::post('/settings', [SettingController::class, 'update'])->name('settings.update');

    // Gestión integral de usuarios y carga masiva CSV
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::post('/users', [UserController::class, 'store'])->name('users.store');
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
    Route::post('/users/import-csv', [UserController::class, 'importCsv'])->name('users.importCsv');

    // Gestión de asignaturas y matrículas
    Route::get('/courses', [CourseController::class, 'index'])->name('courses.index');
    Route::post('/courses', [CourseController::class, 'store'])->name('courses.store');
    Route::delete('/courses/{course}', [CourseController::class, 'destroy'])->name('courses.destroy');
    Route::post('/courses/{course}/enroll', [CourseController::class, 'enroll'])->name('courses.enroll');

    // Solicitudes de restablecimiento de contraseña / Soporte
    Route::get('/solicitudes-soporte', [SupportRequestController::class, 'index'])->name('support.index');
    Route::delete('/solicitudes-soporte/{supportRequest}', [SupportRequestController::class, 'destroy'])->name('support.destroy');
});

/*
|--------------------------------------------------------------------------
| Panel Docente (Role: docente)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:docente'])->prefix('teacher')->name('teacher.')->group(function () {
    Route::get('/dashboard', [AssignmentController::class, 'index'])->name('dashboard');
    Route::post('/courses/{course}/assignments', [AssignmentController::class, 'store'])->name('assignments.store');
    Route::post('/submissions/{submission}/grade', [AssignmentController::class, 'grade'])->name('submissions.grade');
});

/*
|--------------------------------------------------------------------------
| Panel Alumno (Role: alumno)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:alumno'])->prefix('student')->name('student.')->group(function () {
    Route::get('/dashboard', [StudentCourseController::class, 'index'])->name('dashboard');
    Route::post('/assignments/{assignment}/submit', [StudentCourseController::class, 'submit'])->name('assignments.submit');
});

/*
|--------------------------------------------------------------------------
| Rutas de Autenticación (Breeze)
|--------------------------------------------------------------------------
*/

require __DIR__.'/auth.php';