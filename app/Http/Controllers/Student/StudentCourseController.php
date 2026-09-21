<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Assignment;
use App\Models\Submission;
use Illuminate\Http\Request;

class StudentCourseController extends Controller
{
    public function index()
    {
        // Trae los cursos donde el alumno está matriculado
        $courses = auth()->user()->enrolledCourses()
            ->with(['teacher', 'assignments.submissions' => function ($q) {
                $q->where('student_id', auth()->id());
            }])
            ->get();

        return view('student.dashboard', compact('courses'));
    }

    public function submit(Request $request, Assignment $assignment)
    {
        // Validar que el alumno esté matriculado en el curso de la tarea
        if (!$assignment->course->students->contains(auth()->id())) {
            abort(403, 'No estás matriculado en este curso.');
        }

        $request->validate([
            'file' => 'required|file|max:10240', // Máximo 10MB
        ]);

        $path = $request->file('file')->store('submissions', 'public');

        Submission::updateOrCreate(
            [
                'assignment_id' => $assignment->id,
                'student_id' => auth()->id(),
            ],
            [
                'file_path' => $path,
            ]
        );

        return back()->with('success', 'Entrega enviada con éxito.');
    }
}