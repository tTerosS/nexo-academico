<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
            <div>
                <h2 class="font-extrabold text-2xl text-slate-900 leading-tight">
                    Gestión de Cursos y Matrículas
                </h2>
                <p class="text-xs text-slate-500 mt-0.5">Crea asignaturas, asigna docentes responsables y matricula alumnos.</p>
            </div>
            <div>
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-blue-50 text-blue-700 border border-blue-100">
                    <span class="w-2 h-2 rounded-full bg-blue-600"></span>
                    {{ $courses->count() }} cursos activos
                </span>
            </div>
        </div>
    </x-slot>

    <div class="py-8 bg-slate-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- Mensajes Flash -->
            @if(session('success'))
                <div class="p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-xl text-xs font-medium flex items-center gap-2 shadow-sm">
                    <span class="text-base">✓</span> {{ session('success') }}
                </div>
            @endif

            <!-- Formulario Crear Curso -->
            <div class="bg-white p-6 sm:p-7 rounded-2xl shadow-sm border border-slate-200/80">
                <div class="flex items-center space-x-3 mb-5 pb-3 border-b border-slate-100">
                    <div class="w-9 h-9 rounded-xl bg-blue-50 text-blue-700 flex items-center justify-center font-black text-sm">
                        📚
                    </div>
                    <div>
                        <h3 class="text-base font-bold text-slate-800">Aperturar Nueva Asignatura</h3>
                        <p class="text-[11px] text-slate-400">Ingresa el nombre del curso y selecciona el docente a cargo.</p>
                    </div>
                </div>

                <form action="{{ route('admin.courses.store') }}" method="POST" class="grid grid-cols-1 md:grid-cols-12 gap-4 items-end">
                    @csrf
                    <div class="md:col-span-6">
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-1">Nombre de la Asignatura</label>
                        <input type="text" name="name" required placeholder="Ej. Álgebra Lineal y Geometría" 
                               class="w-full px-3.5 py-2.5 bg-slate-50/50 border border-slate-200 rounded-xl text-sm focus:bg-white focus:ring-2 focus:ring-blue-600 focus:border-transparent outline-none transition">
                    </div>

                    <div class="md:col-span-4">
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-1">Docente Responsable</label>
                        <select name="teacher_id" 
                                class="w-full px-3.5 py-2.5 bg-slate-50/50 border border-slate-200 rounded-xl text-sm focus:bg-white focus:ring-2 focus:ring-blue-600 focus:border-transparent outline-none transition">
                            <option value="">-- Sin docente asignado --</option>
                            @foreach($teachers as $teacher)
                                <option value="{{ $teacher->id }}">{{ $teacher->name }} ({{ $teacher->email }})</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="md:col-span-2">
                        <button type="submit" class="w-full py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-xs font-bold shadow-md hover:shadow-lg transition">
                            + Crear Curso
                        </button>
                    </div>
                </form>
            </div>

            <!-- Listado de Cursos y Matrículas -->
            <div class="space-y-4">
                <h3 class="text-sm font-extrabold text-slate-800 uppercase tracking-wider">Cursos Registrados y Matrículas</h3>

                @forelse($courses as $course)
                    <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-200/80 space-y-5">
                        
                        <!-- Encabezado del Curso -->
                        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3 pb-4 border-b border-slate-100">
                            <div>
                                <h4 class="text-lg font-black text-slate-900 leading-snug">{{ $course->name }}</h4>
                                <div class="flex items-center gap-3 mt-1 text-xs text-slate-500">
                                    <span>👨‍🏫 <strong>Docente:</strong> {{ $course->teacher ? $course->teacher->name : 'No asignado' }}</span>
                                    <span>•</span>
                                    <span>👥 <strong>Matriculados:</strong> {{ $course->students->count() }} alumnos</span>
                                </div>
                            </div>

                            <form action="{{ route('admin.courses.destroy', $course) }}" method="POST" onsubmit="return confirm('¿Seguro que deseas eliminar este curso?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-xs text-rose-600 hover:text-rose-800 font-bold px-3 py-1.5 rounded-lg hover:bg-rose-50 transition">
                                    Eliminar Curso
                                </button>
                            </form>
                        </div>

                        <!-- Panel de Matrícula de Alumnos -->
                        <form action="{{ route('admin.courses.enroll', $course) }}" method="POST" class="space-y-3">
                            @csrf
                            <label class="block text-[11px] font-bold text-slate-600 uppercase tracking-wider">
                                Matricular Alumnos a este curso:
                            </label>

                            <div class="grid grid-cols-1 sm:grid-cols-12 gap-3 items-end">
                                <div class="sm:col-span-10">
                                    <select name="student_ids[]" multiple size="3" 
                                            class="w-full px-3.5 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:bg-white focus:ring-2 focus:ring-blue-600 outline-none transition">
                                        @foreach($students as $student)
                                            <option value="{{ $student->id }}" {{ $course->students->contains($student->id) ? 'disabled class=text-slate-300' : '' }}>
                                                {{ $student->name }} ({{ $student->email }}) {{ $course->students->contains($student->id) ? '— ✓ Ya matriculado' : '' }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <span class="text-[10px] text-slate-400 mt-1 block">Presiona Ctrl (o Cmd) para seleccionar varios a la vez.</span>
                                </div>

                                <div class="sm:col-span-2">
                                    <button type="submit" class="w-full py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl text-xs font-bold shadow transition">
                                        Matricular
                                    </button>
                                </div>
                            </div>
                        </form>

                    </div>
                @empty
                    <div class="bg-white rounded-2xl p-8 text-center text-slate-400 text-xs border border-slate-200">
                        Aún no se han creado asignaturas en el campus.
                    </div>
                @endforelse
            </div>

        </div>
    </div>
</x-app-layout>