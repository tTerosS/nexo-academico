<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Panel del Docente - Mis Cursos y Calificaciones') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if(session('success'))
                <div class="p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                    {{ session('success') }}
                </div>
            @endif

            @forelse($courses as $course)
                <div class="bg-white p-6 rounded-lg shadow space-y-4">
                    <h3 class="text-xl font-bold text-gray-800 border-b pb-2">{{ $course->name }}</h3>

                    <!-- Crear Tarea en este curso -->
                    <form action="{{ route('teacher.assignments.store', $course) }}" method="POST" class="bg-gray-50 p-4 rounded border grid grid-cols-1 md:grid-cols-3 gap-3 items-end">
                        @csrf
                        <div>
                            <label class="block text-xs font-semibold text-gray-600">Título de la Tarea</label>
                            <input type="text" name="title" required class="w-full border-gray-300 rounded text-sm">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-gray-600">Fecha Límite</label>
                            <input type="datetime-local" name="due_date" class="w-full border-gray-300 rounded text-sm">
                        </div>
                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded text-sm font-medium">
                            + Crear Tarea
                        </button>
                    </form>

                    <!-- Lista de Tareas y Entregas de Alumnos -->
                    <div class="mt-4 space-y-4">
                        @foreach($course->assignments as $assignment)
                            <div class="border-l-4 border-blue-500 pl-4 py-2 bg-slate-50">
                                <h4 class="font-semibold text-gray-700">{{ $assignment->title }}</h4>
                                <span class="text-xs text-gray-500">Límite: {{ $assignment->due_date ? $assignment->due_date->format('d/m/Y H:i') : 'Sin fecha' }}</span>

                                <div class="mt-3">
                                    <h5 class="text-xs font-bold text-gray-500 uppercase">Entregas de Alumnos:</h5>
                                    @forelse($assignment->submissions as $sub)
                                        <div class="mt-2 p-3 bg-white rounded border flex flex-col md:flex-row justify-between items-start md:items-center gap-2">
                                            <div>
                                                <span class="font-medium text-sm text-gray-800">{{ $sub->student->name }}</span>
                                                <a href="{{ asset('storage/' . $sub->file_path) }}" target="_blank" class="ml-2 text-xs text-blue-600 underline">Descargar archivo</a>
                                            </div>
                                            <!-- Formulario Calificar -->
                                            <form action="{{ route('teacher.submissions.grade', $sub) }}" method="POST" class="flex gap-2 items-center">
                                                @csrf
                                                <input type="number" step="0.1" name="grade" min="0" max="20" placeholder="Nota" value="{{ $sub->grade }}" required class="w-20 border-gray-300 rounded text-sm p-1">
                                                <input type="text" name="feedback" placeholder="Comentario" value="{{ $sub->feedback }}" class="border-gray-300 rounded text-sm p-1">
                                                <button type="submit" class="px-3 py-1 bg-emerald-600 text-white text-xs rounded">Guardar</button>
                                            </form>
                                        </div>
                                    @empty
                                        <p class="text-xs text-gray-400 mt-1">Aún no hay entregas de alumnos.</p>
                                    @endforelse
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @empty
                <div class="bg-white p-6 rounded shadow text-gray-500">
                    No tienes cursos asignados como docente todavía.
                </div>
            @endforelse

        </div>
    </div>
</x-app-layout>