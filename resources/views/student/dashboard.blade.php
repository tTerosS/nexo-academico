<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Panel del Alumno - Mis Tareas y Entregas') }}
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
                    <div class="border-b pb-2">
                        <h3 class="text-xl font-bold text-gray-800">{{ $course->name }}</h3>
                        <p class="text-xs text-gray-500">Docente: {{ $course->teacher ? $course->teacher->name : 'Por asignar' }}</p>
                    </div>

                    <div class="space-y-4">
                        @forelse($course->assignments as $assignment)
                            @php
                                $submission = $assignment->submissions->first();
                            @endphp
                            <div class="p-4 bg-gray-50 border rounded-md">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <h4 class="font-semibold text-gray-800">{{ $assignment->title }}</h4>
                                        <p class="text-xs text-gray-500">Límite: {{ $assignment->due_date ? $assignment->due_date->format('d/m/Y H:i') : 'Sin fecha límite' }}</p>
                                    </div>
                                    <div>
                                        @if($submission && $submission->grade !== null)
                                            <span class="px-2 py-1 bg-green-100 text-green-800 font-bold rounded text-sm">
                                                Nota: {{ $submission->grade }}/20
                                            </span>
                                        @elseif($submission)
                                            <span class="px-2 py-1 bg-yellow-100 text-yellow-800 rounded text-xs">Entregado (Pendiente de nota)</span>
                                        @else
                                            <span class="px-2 py-1 bg-red-100 text-red-800 rounded text-xs">Sin entregar</span>
                                        @endif
                                    </div>
                                </div>

                                <!-- Subir Archivo de Entrega -->
                                <form action="{{ route('student.assignments.submit', $assignment) }}" method="POST" enctype="multipart/form-data" class="mt-4 pt-3 border-t flex flex-col md:flex-row gap-3 items-end">
                                    @csrf
                                    <div class="w-full">
                                        <label class="block text-xs text-gray-600 mb-1">
                                            {{ $submission ? 'Reemplazar entrega de archivo:' : 'Subir archivo de tarea:' }}
                                        </label>
                                        <input type="file" name="file" required class="w-full border p-1 rounded text-sm bg-white">
                                    </div>
                                    <button type="submit" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded text-sm whitespace-nowrap">
                                        {{ $submission ? 'Reenviar Archivo' : 'Entregar Tarea' }}
                                    </button>
                                </form>

                                @if($submission && $submission->feedback)
                                    <div class="mt-2 p-2 bg-blue-50 border-l-2 border-blue-400 text-xs text-gray-700">
                                        <strong>Comentario del profesor:</strong> {{ $submission->feedback }}
                                    </div>
                                @endif
                            </div>
                        @empty
                            <p class="text-xs text-gray-400">No hay tareas pendientes en este curso.</p>
                        @endforelse
                    </div>
                </div>
            @empty
                <div class="bg-white p-6 rounded shadow text-gray-500">
                    No estás matriculado en ningún curso actualmente.
                </div>
            @endforelse

        </div>
    </div>
</x-app-layout>