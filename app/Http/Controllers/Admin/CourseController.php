<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\User;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function index()
    {
        $courses = Course::with(['teacher', 'students'])->latest()->get();
        $teachers = User::where('role', 'docente')->get();
        $students = User::where('role', 'alumno')->get();

        return view('admin.courses.index', compact('courses', 'teachers', 'students'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'teacher_id' => 'nullable|exists:users,id',
        ]);

        Course::create($request->only('name', 'description', 'teacher_id'));

        return redirect()->route('admin.courses.index')->with('success', 'Curso creado con éxito.');
    }

    public function enroll(Request $request, Course $course)
    {
        $request->validate([
            'student_ids' => 'required|array',
            'student_ids.*' => 'exists:users,id',
        ]);

        // Sincroniza los alumnos sin borrar asignaciones previas si se agregan nuevos
        $course->students()->syncWithoutDetaching($request->student_ids);

        return redirect()->route('admin.courses.index')->with('success', 'Alumnos matriculados exitosamente.');
    }

    public function destroy(Course $course)
    {
        $course->delete();
        return redirect()->route('admin.courses.index')->with('success', 'Curso eliminado.');
    }
}