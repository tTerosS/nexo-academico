<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Soporte de Acceso - {{ $institutionName ?? 'NEXO ACADÉMICO' }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .bg-campus-blue { background-color: #1a3a8f; }
        .bg-campus-darkblue { background-color: #0f172a; }
    </style>
</head>
<body class="bg-[#f8fafc] text-gray-800 flex flex-col min-h-screen font-sans">

    <!-- CABECERA -->
    <header class="bg-campus-blue text-white shadow-md sticky top-0 z-40">
        <div class="w-full px-6 sm:px-10 h-16 flex items-center justify-between">
            <div class="flex items-center space-x-3">
                <a href="{{ route('home') }}" class="flex items-center space-x-3">
                    <img src="{{ asset('images/logo.jpg') }}" 
                         alt="Logo" 
                         onerror="this.onerror=null; this.src='https://ui-avatars.com/api/?name=NA&background=ffffff&color=1a3a8f&bold=true';" 
                         class="h-10 w-10 object-contain rounded-full bg-white p-0.5 shadow border border-white">
                    <div>
                        <span class="font-extrabold text-base tracking-wider uppercase text-white block leading-tight">
                            {{ $institutionName ?? 'NEXO ACADÉMICO' }}
                        </span>
                        <span class="text-[10px] text-blue-200 uppercase tracking-widest font-semibold">Campus Virtual</span>
                    </div>
                </a>
            </div>
            <div>
                <a href="{{ route('home') }}" class="bg-white/10 hover:bg-white/20 text-white px-3.5 py-1.5 rounded-lg text-xs font-bold transition">
                    ← Volver
                </a>
            </div>
        </div>
    </header>

    <!-- FORMULARIO INSTITUCIONAL -->
    <main class="flex-grow flex items-center justify-center py-10 px-4 sm:px-6">
        <div class="w-full max-w-lg bg-white rounded-2xl shadow-xl border border-slate-200/80 p-6 sm:p-8 space-y-6">
            
            <div class="space-y-2 border-b border-slate-100 pb-4">
                <h2 class="text-xl font-black text-slate-900 tracking-tight">
                    Restablecer acceso al Campus
                </h2>
                <p class="text-xs text-slate-500 leading-relaxed">
                    Para reajustar su contraseña, ingrese su correo electrónico institucional o su nombre completo. La solicitud será enviada a la administración para habilitar su acceso a la brevedad.
                </p>
            </div>

            @if (session('status'))
                <div class="p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-semibold rounded-xl leading-relaxed">
                    ✓ {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('password.support.request') }}" class="space-y-4">
                @csrf

                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">
                        Buscar por correo electrónico o nombre de usuario
                    </label>
                    <input type="text" 
                           name="identifier" 
                           required 
                           placeholder="Ej. alumno@osalvac.pe o Juan Pérez" 
                           class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-600 transition">
                </div>

                <div class="pt-2">
                    <button type="submit" 
                            class="w-full py-2.5 px-4 bg-blue-700 hover:bg-blue-800 text-white font-bold text-xs uppercase tracking-wider rounded-xl shadow transition">
                        Enviar Solicitud al Administrador
                    </button>
                </div>
            </form>

            <!-- Soporte directo por WhatsApp -->
            <div class="pt-4 border-t border-slate-100 text-center space-y-3">
                <span class="text-xs text-slate-400 block">¿Necesitas acceso urgente?</span>
                <a href="https://wa.me/51999999999?text=Hola%20administración,%20solicito%20ayuda%20para%20recuperar%20el%20acceso%20a%20mi%20cuenta%20de%20Nexo%20Académico." 
                   target="_blank"
                   class="inline-flex items-center justify-center gap-2 w-full py-2.5 px-4 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs uppercase tracking-wider rounded-xl shadow transition">
                    <span>💬</span> Contactar por WhatsApp al Administrador
                </a>
            </div>

        </div>
    </main>

    <!-- FOOTER -->
    <footer class="bg-campus-darkblue text-white py-5 text-center text-xs border-t-2 border-blue-600">
        <p>&copy; 2026 <strong>{{ $institutionName ?? 'NEXO ACADÉMICO' }}</strong>. Todos los derechos reservados.</p>
    </footer>

</body>
</html>