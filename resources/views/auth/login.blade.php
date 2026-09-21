<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Iniciar Sesión - {{ $institutionName ?? 'GRUPO OSALVAC SRL' }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        :root { --brand-color: {{ $primaryColor ?? '#4f46e5' }}; }
        .bg-brand { background-color: var(--brand-color); }
        .text-brand { color: var(--brand-color); }
        .hover-bg-brand:hover { filter: brightness(0.9); }
    </style>
</head>
<body class="antialiased bg-slate-100 min-h-screen flex items-center justify-center p-4">

    <div class="w-full max-w-md bg-white rounded-3xl shadow-2xl p-8 border border-slate-100">
        <div class="mb-6 text-center">
            <a href="{{ route('home') }}" class="inline-block">
                <div class="w-14 h-14 rounded-2xl bg-brand text-white flex items-center justify-center mx-auto mb-3 font-black text-2xl shadow-md">
                    {{ substr($institutionName ?? 'G', 0, 1) }}
                </div>
            </a>
            <h3 class="text-2xl font-black text-slate-900">{{ $institutionName ?? 'GRUPO OSALVAC SRL' }}</h3>
            <p class="text-xs font-semibold text-slate-400 mt-1 uppercase tracking-wider">Campus Virtual • Inicio de Sesión</p>
        </div>

        <!-- Errores de Validación -->
        @if ($errors->any())
            <div class="mb-4 p-3 rounded-xl bg-red-50 border border-red-200 text-xs text-red-600 font-medium">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}" class="space-y-4">
            @csrf

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Correo Institucional</label>
                <input type="email" name="email" value="{{ old('email') }}" required autofocus class="w-full px-4 py-3 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-brand focus:border-transparent outline-none transition" placeholder="usuario@osalvac.pe">
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Contraseña</label>
                <input type="password" name="password" required class="w-full px-4 py-3 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-brand focus:border-transparent outline-none transition" placeholder="••••••••">
            </div>

            <div class="flex items-center justify-between text-xs text-slate-500 pt-1">
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="checkbox" name="remember" class="rounded border-slate-300 text-indigo-600 focus:ring-indigo-500">
                    <span>Recordarme</span>
                </label>
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="text-brand hover:underline font-medium">¿Olvidaste tu clave?</a>
                @endif
            </div>

            <button type="submit" class="w-full py-3.5 rounded-xl font-bold text-sm bg-brand text-white shadow-md hover-bg-brand transition">
                Acceder a mi Cuenta
            </button>
        </form>

        <div class="mt-6 pt-6 border-t border-slate-100 text-center">
            <a href="{{ route('home') }}" class="text-xs font-semibold text-slate-500 hover:text-slate-800 transition">
                ← Volver a la página principal
            </a>
        </div>
    </div>

</body>
</html>