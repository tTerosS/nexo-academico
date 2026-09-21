<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Assignment;
use App\Models\Submission;
use Illuminate\Http\Request;

class AssignmentController extends Controller
{
    public function index()
    {
        // Trae los cursos asignados al docente autenticado
        $courses = Course::where('teacher_id', auth()->id())
            ->with(['assignments.submissions.student'])
            ->get();

        return view('teacher.dashboard', compact('courses'));
    }

    public function store(Request $request, Course $course)
    {
        // Validar que el docente sea el dueño del curso
        if ($course->teacher_id !== auth()->id()) {
            abort(403);
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'due_date' => 'nullable|date',
        ]);

        $course->assignments()->create($request->only('title', 'description', 'due_date'));

        return back()->with('success', 'Tarea creada correctamente.');
    }

    public function grade(Request $request, Submission $submission)
    {
        // Validar que el docente pertenezca al curso de esta entrega
        if ($submission->assignment->course->teacher_id !== auth()->id()) {
            abort(403);
        }

        $request->validate([
            'grade' => 'required|numeric|min:0|max:20',
            'feedback' => 'nullable|string',
        ]);

        $submission->update($request->only('grade', 'feedback'));

        return back()->with('success', 'Calificación registrada.');
    }
}