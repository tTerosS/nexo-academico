<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h2 class="font-bold text-2xl text-gray-800 leading-tight">
                    NEXO Campus - Configuración Visual
                </h2>
                <p class="text-sm text-gray-500">Administrador: {{ Auth::user()->name }}</p>
            </div>

            <!-- Selector de sección tipo Pestañas -->
            <div class="inline-flex rounded-md shadow-sm bg-gray-200 p-1">
                <a href="{{ route('admin.users.index') }}" 
                   class="px-4 py-2 text-sm font-medium rounded-md text-gray-600 hover:text-gray-900">
                    👥 Usuarios
                </a>
                <a href="{{ route('admin.courses.index') }}" 
                   class="px-4 py-2 text-sm font-medium rounded-md text-gray-600 hover:text-gray-900">
                    📚 Cursos y Matrículas
                </a>
                <a href="{{ route('admin.settings.edit') }}" 
                   class="px-4 py-2 text-sm font-semibold rounded-md bg-white text-indigo-700 shadow">
                    🎨 Visual
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white p-6 rounded-lg shadow space-y-6">
                <h3 class="text-lg font-bold text-gray-800 border-b pb-2">Identidad Institucional del Campus</h3>
                
                <form action="{{ route('admin.settings.update') }}" method="POST" class="space-y-5">
                    @csrf
                    <div>
                        <label class="block text-sm font-semibold text-gray-700">Nombre de la Institución / Empresa</label>
                        <input type="text" name="institution_name" value="{{ old('institution_name', $institution_name) }}" required class="w-full mt-1 border-gray-300 rounded-md shadow-sm">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700">Color Primario Institucional</label>
                        <div class="flex items-center gap-3 mt-1">
                            <input type="color" name="primary_color" value="{{ old('primary_color', $primary_color) }}" class="h-10 w-20 border rounded cursor-pointer">
                            <span class="text-xs text-gray-500">Selecciona el color temático para los encabezados y botones.</span>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700">Mensaje de Bienvenida</label>
                        <textarea name="welcome_message" rows="3" class="w-full mt-1 border-gray-300 rounded-md shadow-sm">{{ old('welcome_message', $welcome_message) }}</textarea>
                    </div>

                    <div class="pt-4 border-t">
                        <button type="submit" class="px-5 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-md text-sm font-medium">
                            Guardar Ajustes Visuales
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>