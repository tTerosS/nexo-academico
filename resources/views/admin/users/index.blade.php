<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
            <div>
                <h2 class="font-extrabold text-2xl text-slate-900 leading-tight">
                    Gestión de Usuarios
                </h2>
                <p class="text-xs text-slate-500 mt-0.5">Administra los accesos de docentes, alumnos y personal administrativo.</p>
            </div>
            <div class="flex items-center space-x-2">
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-blue-50 text-blue-700 border border-blue-100">
                    <span class="w-2 h-2 rounded-full bg-blue-600"></span>
                    Total: {{ $users->total() }} registrados
                </span>
            </div>
        </div>
    </x-slot>

    <div class="py-8 bg-slate-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- Alertas Flash -->
            @if(session('success'))
                <div class="p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-xl text-xs font-medium flex items-center gap-2 shadow-sm">
                    <span class="text-base">✓</span> {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="p-4 bg-rose-50 border border-rose-200 text-rose-800 rounded-xl text-xs font-medium flex items-center gap-2 shadow-sm">
                    <span class="text-base">⚠</span> {{ session('error') }}
                </div>
            @endif

            <!-- Formularios de Creación e Importación -->
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
                
                <!-- Crear Usuario Individual -->
                <div class="lg:col-span-7 bg-white p-6 sm:p-7 rounded-2xl shadow-sm border border-slate-200/80">
                    <div class="flex items-center space-x-3 mb-5 pb-3 border-b border-slate-100">
                        <div class="w-9 h-9 rounded-xl bg-blue-50 text-blue-700 flex items-center justify-center font-black text-sm">
                            +
                        </div>
                        <div>
                            <h3 class="text-base font-bold text-slate-800">Registrar Nuevo Usuario</h3>
                            <p class="text-[11px] text-slate-400">Completa los datos para dar de alta una cuenta individual.</p>
                        </div>
                    </div>

                    <form action="{{ route('admin.users.store') }}" method="POST" class="space-y-4">
                        @csrf
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-1">Nombre Completo</label>
                                <input type="text" name="name" required placeholder="Ej. Juan Pérez" 
                                       class="w-full px-3.5 py-2.5 bg-slate-50/50 border border-slate-200 rounded-xl text-sm focus:bg-white focus:ring-2 focus:ring-blue-600 focus:border-transparent outline-none transition">
                            </div>

                            <div>
                                <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-1">Correo Electrónico</label>
                                <input type="email" name="email" required placeholder="ejemplo@nexo.pe" 
                                       class="w-full px-3.5 py-2.5 bg-slate-50/50 border border-slate-200 rounded-xl text-sm focus:bg-white focus:ring-2 focus:ring-blue-600 focus:border-transparent outline-none transition">
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-1">Rol en el Campus</label>
                                <select name="role" required 
                                        class="w-full px-3.5 py-2.5 bg-slate-50/50 border border-slate-200 rounded-xl text-sm focus:bg-white focus:ring-2 focus:ring-blue-600 focus:border-transparent outline-none transition">
                                    <option value="alumno">Alumno</option>
                                    <option value="docente">Docente</option>
                                    <option value="administrador">Administrador</option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-1">Contraseña</label>
                                <input type="password" name="password" required placeholder="Mínimo 6 caracteres" 
                                       class="w-full px-3.5 py-2.5 bg-slate-50/50 border border-slate-200 rounded-xl text-sm focus:bg-white focus:ring-2 focus:ring-blue-600 focus:border-transparent outline-none transition">
                            </div>
                        </div>

                        <div class="pt-2 flex justify-end">
                            <button type="submit" class="px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-xs font-bold shadow-md hover:shadow-lg transition">
                                Guardar Usuario
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Carga Masiva CSV -->
                <div class="lg:col-span-5 bg-white p-6 sm:p-7 rounded-2xl shadow-sm border border-slate-200/80 flex flex-col justify-between">
                    <div>
                        <div class="flex items-center space-x-3 mb-5 pb-3 border-b border-slate-100">
                            <div class="w-9 h-9 rounded-xl bg-emerald-50 text-emerald-700 flex items-center justify-center font-black text-sm">
                                📄
                            </div>
                            <div>
                                <h3 class="text-base font-bold text-slate-800">Carga Masiva (CSV)</h3>
                                <p class="text-[11px] text-slate-400">Importa múltiples alumnos o docentes de una vez.</p>
                            </div>
                        </div>

                        <div class="p-3.5 bg-slate-50 border border-slate-200/70 rounded-xl text-[11px] text-slate-600 mb-4 leading-relaxed">
                            <strong>Formato requerido en el archivo .csv:</strong><br>
                            <span class="text-slate-500 font-mono text-[10px] block mt-1">Nombre, Correo, Rol (alumno/docente), Contraseña</span>
                        </div>

                        <form action="{{ route('admin.users.importCsv') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                            @csrf
                            <div>
                                <input type="file" name="csv_file" accept=".csv" required 
                                       class="w-full text-xs text-slate-500 file:mr-3 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 cursor-pointer border border-dashed border-slate-300 rounded-xl p-2 bg-slate-50/30">
                            </div>

                            <button type="submit" class="w-full py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl text-xs font-bold shadow transition flex items-center justify-center gap-2">
                                <span>↑</span> Subir e Importar Archivo
                            </button>
                        </form>
                    </div>
                </div>

            </div>

            <!-- Tabla de Usuarios Registrados -->
            <div class="bg-white shadow-sm rounded-2xl border border-slate-200/80 overflow-hidden">
                <div class="p-5 border-b border-slate-100 flex items-center justify-between">
                    <div>
                        <h3 class="text-base font-bold text-slate-800">Usuarios en la Plataforma</h3>
                        <p class="text-[11px] text-slate-400">Listado general ordenado por los más recientes.</p>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-slate-50 text-[11px] uppercase tracking-wider text-slate-500 font-bold border-b border-slate-200/70">
                                <th class="py-3 px-5">Usuario</th>
                                <th class="py-3 px-5">Correo Electrónico</th>
                                <th class="py-3 px-5">Rol Asignado</th>
                                <th class="py-3 px-5 text-right">Acción</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 text-xs text-slate-700">
                            @foreach($users as $user)
                                <tr class="hover:bg-slate-50/70 transition">
                                    <td class="py-3.5 px-5 font-semibold text-slate-900 flex items-center gap-2.5">
                                        <div class="w-7 h-7 rounded-full bg-slate-100 text-slate-700 font-bold flex items-center justify-center text-[11px]">
                                            {{ substr($user->name, 0, 1) }}
                                        </div>
                                        {{ $user->name }}
                                    </td>
                                    <td class="py-3.5 px-5 text-slate-500 font-mono text-[11px]">{{ $user->email }}</td>
                                    <td class="py-3.5 px-5">
                                        <span class="px-2.5 py-1 text-[10px] font-extrabold uppercase rounded-full tracking-wide
                                            {{ $user->role === 'administrador' ? 'bg-purple-100 text-purple-800 border border-purple-200' : '' }}
                                            {{ $user->role === 'docente' ? 'bg-blue-100 text-blue-800 border border-blue-200' : '' }}
                                            {{ $user->role === 'alumno' ? 'bg-emerald-100 text-emerald-800 border border-emerald-200' : '' }}">
                                            {{ $user->role }}
                                        </span>
                                    </td>
                                    <td class="py-3.5 px-5 text-right">
                                        @if($user->email !== 'admin@osalvac.pe')
                                            <form action="{{ route('admin.users.destroy', $user) }}" method="POST" onsubmit="return confirm('¿Deseas eliminar definitivamente este usuario?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-rose-600 hover:text-rose-800 font-bold hover:underline">
                                                    Eliminar
                                                </button>
                                            </form>
                                        @else
                                            <span class="text-[10px] text-slate-400 font-semibold italic">Principal</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="p-4 border-t border-slate-100 bg-slate-50/50">
                    {{ $users->links() }}
                </div>
            </div>

        </div>
    </div>
</x-app-layout>