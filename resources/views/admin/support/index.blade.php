<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-extrabold text-2xl text-slate-900 leading-tight">
                Solicitudes de Restablecimiento de Contraseña
            </h2>
            <span class="px-3 py-1 bg-blue-50 text-blue-700 rounded-full text-xs font-bold border border-blue-100">
                {{ $requests->total() }} solicitudes recibidas
            </span>
        </div>
    </x-slot>

    <div class="py-8 bg-slate-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('success'))
                <div class="mb-4 p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-xl text-xs font-medium">
                    ✓ {{ session('success') }}
                </div>
            @endif

            <div class="bg-white shadow-sm rounded-2xl border border-slate-200/80 overflow-hidden">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50 text-[11px] uppercase tracking-wider text-slate-500 font-bold border-b border-slate-200/70">
                            <th class="py-3.5 px-5">Usuario / Correo Solicitante</th>
                            <th class="py-3.5 px-5">Fecha y Hora</th>
                            <th class="py-3.5 px-5 text-right">Acción</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-xs text-slate-700">
                        @forelse($requests as $req)
                            <tr class="hover:bg-slate-50/70 transition">
                                <td class="py-3.5 px-5 font-bold text-slate-900">
                                    {{ $req->identifier }}
                                </td>
                                <td class="py-3.5 px-5 text-slate-500">
                                    {{ $req->created_at->format('d/m/Y H:i A') }}
                                </td>
                                <td class="py-3.5 px-5 text-right flex justify-end gap-2">
                                    <form action="{{ route('admin.support.destroy', $req) }}" method="POST" onsubmit="return confirm('¿Marcar como atendida y quitar de la lista?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="px-3 py-1 bg-emerald-50 hover:bg-emerald-100 text-emerald-700 border border-emerald-200 rounded-lg text-xs font-bold transition">
                                            ✓ Marcar Atendido
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="py-8 text-center text-slate-400">
                                    No hay solicitudes pendientes en este momento.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <div class="p-4 border-t border-slate-100 bg-slate-50/50">
                    {{ $requests->links() }}
                </div>
            </div>

        </div>
    </div>
</x-app-layout>