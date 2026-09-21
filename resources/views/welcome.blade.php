<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $institutionName ?? 'NEXO ACADÉMICO' }} - Campus Virtual</title>

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        [x-cloak] { display: none !important; }
        .bg-campus-blue { background-color: #1a3a8f; }
        .bg-campus-darkblue { background-color: #0f172a; }
        .text-campus-blue { color: #1a3a8f; }
    </style>
</head>
<body class="bg-[#f8fafc] text-gray-800 flex flex-col min-h-screen font-sans" x-data="{ openLoginModal: {{ $errors->any() ? 'true' : 'false' }} }">

    <!-- 1. HEADER / BARRA DE NAVEGACIÓN -->
    <header class="bg-campus-blue text-white shadow-md sticky top-0 z-40">
        <div class="w-full px-6 sm:px-10 h-16 flex items-center justify-between">
            
            <div class="flex items-center space-x-3">
                <a href="{{ route('home') }}" class="flex items-center space-x-3 group">
                    <img src="{{ asset('images/logo.jpg') }}" 
                         alt="Logo NEXO Académico" 
                         onerror="this.onerror=null; this.src='https://ui-avatars.com/api/?name=NA&background=ffffff&color=1a3a8f&bold=true';" 
                         class="h-11 w-11 object-contain rounded-full bg-white p-0.5 shadow border border-white transition group-hover:scale-105">
                    <span class="font-extrabold text-base sm:text-lg tracking-wider uppercase text-white">
                        {{ $institutionName ?? 'NEXO ACADÉMICO' }}
                    </span>
                </a>
                
                <span class="hidden sm:inline-block text-white/30 pl-2">|</span>
                
                <a href="{{ route('home') }}" class="hidden sm:inline-block bg-white/10 hover:bg-white/20 px-3 py-1.5 rounded text-xs font-semibold text-white transition">
                    Página Principal
                </a>
            </div>

            <div class="flex items-center">
                @auth
                    <a href="{{ route('dashboard') }}" class="bg-white text-blue-900 font-bold px-5 py-2 rounded-md shadow text-sm hover:bg-gray-100 transition">
                        Mi Aula Virtual →
                    </a>
                @else
                    <button type="button" @click="openLoginModal = true" class="bg-white text-blue-900 hover:bg-blue-50 font-bold text-sm tracking-wide px-6 py-2 rounded-md shadow transition">
                        Acceder
                    </button>
                @endauth
            </div>

        </div>
    </header>

    <!-- 2. BANNER HERO: CARRUSEL INTERACTIVO CON FLECHAS -->
    <main class="flex-grow">
        <section class="relative w-full bg-slate-900 min-h-[440px] md:min-h-[500px] flex items-center justify-center overflow-hidden select-none"
                 x-data="{
                    activeSlide: 0,
                    timer: null,
                    slides: [
                        {
                            image: 'https://images.unsplash.com/photo-1524178232363-1fb2b075b655?auto=format&fit=crop&w=1920&q=80',
                            tag: 'MÁS QUE ACADEMIA, TU PRÓXIMO LOGRO',
                            title: '{{ $institutionName ?? 'NEXO ACADÉMICO' }}',
                            desc: '{{ $welcomeMessage ?? 'Bienvenido a la plataforma educativa NEXO Campus. Accede a tus asignaturas, entrega de tareas y evaluaciones formativas.' }}'
                        },
                        {
                            image: 'https://images.unsplash.com/photo-1523240795612-9a054b0db644?auto=format&fit=crop&w=1920&q=80',
                            tag: 'PREPARACIÓN INTEGRAL',
                            title: 'IMPULSA TU APRENDIZAJE',
                            desc: 'Clases virtuales y presenciales con docentes de primer nivel para que alcances tus metas académicas.'
                        },
                        {
                            image: 'https://images.unsplash.com/photo-1531482615713-2afd69097998?auto=format&fit=crop&w=1920&q=80',
                            tag: 'ENTORNO VIRTUAL ACTIVO',
                            title: 'AULAS Y EVALUACIONES 24/7',
                            desc: 'Entrega tus tareas, revisa tus avances formativos y consulta tus notas en cualquier momento.'
                        }
                    ],
                    next() {
                        this.activeSlide = (this.activeSlide === this.slides.length - 1) ? 0 : this.activeSlide + 1;
                    },
                    prev() {
                        this.activeSlide = (this.activeSlide === 0) ? this.slides.length - 1 : this.activeSlide - 1;
                    },
                    startAutoSlide() {
                        this.timer = setInterval(() => { this.next(); }, 6000);
                    },
                    stopAutoSlide() {
                        clearInterval(this.timer);
                    }
                 }"
                 x-init="startAutoSlide()"
                 @mouseenter="stopAutoSlide()"
                 @mouseleave="startAutoSlide()">
            
            <!-- Imágenes de fondo con transiciones -->
            <template x-for="(slide, index) in slides" :key="index">
                <div x-show="activeSlide === index" 
                     x-transition:enter="transition ease-out duration-700"
                     x-transition:enter-start="opacity-0 scale-105"
                     x-transition:enter-end="opacity-75 scale-100"
                     x-transition:leave="transition ease-in duration-500"
                     x-transition:leave-start="opacity-75"
                     x-transition:leave-end="opacity-0"
                     class="absolute inset-0 w-full h-full">
                    <img :src="slide.image" 
                         :alt="slide.title" 
                         class="w-full h-full object-cover object-center">
                </div>
            </template>

            <!-- FLECHA IZQUIERDA (PREV) -->
            <button type="button" 
                    @click="prev()"
                    title="Anterior diapositiva"
                    class="absolute left-4 sm:left-8 top-1/2 -translate-y-1/2 w-11 h-11 rounded-full bg-blue-700/90 hover:bg-blue-600 active:scale-95 text-white flex items-center justify-center font-bold text-xl shadow-xl transition-all duration-200 z-20 cursor-pointer">
                &#10094;
            </button>

            <!-- RECUADRO FLOTANTE CON TEXTO DINÁMICO -->
            <div class="relative z-10 w-full max-w-[1400px] mx-auto px-6 sm:px-10 flex justify-end">
                <div class="w-full max-w-lg bg-black/75 backdrop-blur-md p-6 sm:p-8 rounded-2xl shadow-2xl text-white space-y-4 border border-white/10 transition-all duration-300">
                    <span class="inline-block text-xs uppercase tracking-widest text-blue-300 font-bold"
                          x-text="slides[activeSlide].tag"></span>
                    
                    <h1 class="text-2xl sm:text-3xl lg:text-4xl font-black uppercase tracking-tight leading-tight"
                        x-text="slides[activeSlide].title"></h1>
                    
                    <p class="text-xs sm:text-sm text-gray-200 leading-relaxed"
                       x-text="slides[activeSlide].desc"></p>
                    
                    <div class="pt-2">
                        @auth
                            <a href="{{ route('dashboard') }}" class="inline-block bg-blue-600 hover:bg-blue-700 text-white text-xs uppercase tracking-wider font-bold px-6 py-2.5 rounded-lg shadow transition">
                                Ir al Campus →
                            </a>
                        @else
                            <button type="button" 
                                    @click="openLoginModal = true" 
                                    class="inline-block bg-blue-600 hover:bg-blue-700 text-white text-xs uppercase tracking-wider font-bold px-6 py-2.5 rounded-lg shadow transition">
                                Saber Más
                            </button>
                        @endauth
                    </div>
                </div>
            </div>

            <!-- FLECHA DERECHA (NEXT) -->
            <button type="button" 
                    @click="next()"
                    title="Siguiente diapositiva"
                    class="absolute right-4 sm:right-8 top-1/2 -translate-y-1/2 w-11 h-11 rounded-full bg-blue-700/90 hover:bg-blue-600 active:scale-95 text-white flex items-center justify-center font-bold text-xl shadow-xl transition-all duration-200 z-20 cursor-pointer">
                &#10095;
            </button>

            <!-- INDICADORES INFERIORES (PUNTOS) -->
            <div class="absolute bottom-4 left-1/2 -translate-x-1/2 flex space-x-2 z-20">
                <template x-for="(slide, index) in slides" :key="index">
                    <button type="button" 
                            @click="activeSlide = index"
                            :class="activeSlide === index ? 'bg-blue-500 w-7' : 'bg-white/50 w-2 hover:bg-white'"
                            class="h-2 rounded-full transition-all duration-300 cursor-pointer"></button>
                </template>
            </div>

        </section>

        <!-- 3. CURSOS DESTACADOS -->
        <section class="max-w-[1400px] mx-auto px-6 sm:px-10 py-14">
            
            <div class="mb-8">
                <span class="text-xs font-bold tracking-widest text-blue-600 uppercase block mb-1">
                    Tu futuro empieza aquí
                </span>
                <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">
                    Cursos destacados
                </h2>
                <p class="text-xs sm:text-sm text-slate-500 mt-1">
                    Programas diseñados para potenciar tu rendimiento académico y ayudarte a alcanzar tus metas.
                </p>
            </div>

            <!-- Grid de 4 tarjetas -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
                
                <!-- Card 1: Matemática -->
                <div class="bg-white rounded-2xl p-5 border border-slate-200/80 shadow-sm hover:shadow-md transition flex flex-col justify-between group">
                    <div class="flex items-start space-x-4">
                        <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center text-xl flex-shrink-0 group-hover:scale-105 transition">
                            🧮
                        </div>
                        <div>
                            <h3 class="font-bold text-slate-800 text-sm">Matemática</h3>
                            <p class="text-[11px] text-slate-500 mt-1 leading-snug">
                                Desde lo esencial hasta nivel avanzado.
                            </p>
                        </div>
                    </div>
                    <div class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-between">
                        <span class="text-[10px] font-semibold text-blue-700 bg-blue-50 px-2.5 py-1 rounded-full">
                            Presencial | Virtual
                        </span>
                    </div>
                </div>

                <!-- Card 2: Ciencias -->
                <div class="bg-white rounded-2xl p-5 border border-slate-200/80 shadow-sm hover:shadow-md transition flex flex-col justify-between group">
                    <div class="flex items-start space-x-4">
                        <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center text-xl flex-shrink-0 group-hover:scale-105 transition">
                            ⚛️
                        </div>
                        <div>
                            <h3 class="font-bold text-slate-800 text-sm">Ciencias</h3>
                            <p class="text-[11px] text-slate-500 mt-1 leading-snug">
                                Física, Química y Biología explicadas de forma simple.
                            </p>
                        </div>
                    </div>
                    <div class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-between">
                        <span class="text-[10px] font-semibold text-blue-700 bg-blue-50 px-2.5 py-1 rounded-full">
                            Presencial | Virtual
                        </span>
                    </div>
                </div>

                <!-- Card 3: Letras -->
                <div class="bg-white rounded-2xl p-5 border border-slate-200/80 shadow-sm hover:shadow-md transition flex flex-col justify-between group">
                    <div class="flex items-start space-x-4">
                        <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center text-xl flex-shrink-0 group-hover:scale-105 transition">
                            📖
                        </div>
                        <div>
                            <h3 class="font-bold text-slate-800 text-sm">Letras</h3>
                            <p class="text-[11px] text-slate-500 mt-1 leading-snug">
                                Comunicación, Literatura y Razonamiento Verbal.
                            </p>
                        </div>
                    </div>
                    <div class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-between">
                        <span class="text-[10px] font-semibold text-blue-700 bg-blue-50 px-2.5 py-1 rounded-full">
                            Presencial | Virtual
                        </span>
                    </div>
                </div>

                <!-- Card 4: Preparación universitaria -->
                <div class="bg-white rounded-2xl p-5 border border-slate-200/80 shadow-sm hover:shadow-md transition flex flex-col justify-between group">
                    <div class="flex items-start space-x-4">
                        <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center text-xl flex-shrink-0 group-hover:scale-105 transition">
                            📈
                        </div>
                        <div>
                            <h3 class="font-bold text-slate-800 text-sm">Preparación universitaria</h3>
                            <p class="text-[11px] text-slate-500 mt-1 leading-snug">
                                Ciclos intensivos y simulacros para tu ingreso.
                            </p>
                        </div>
                    </div>
                    <div class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-between">
                        <span class="text-[10px] font-semibold text-blue-700 bg-blue-50 px-2.5 py-1 rounded-full">
                            Presencial | Virtual
                        </span>
                    </div>
                </div>

            </div>
        </section>
    </main>

    <!-- 4. FOOTER AZUL INSTITUCIONAL -->
    <footer class="bg-campus-darkblue text-white pt-12 pb-8 border-t-2 border-blue-600">
        <div class="max-w-[1400px] mx-auto px-6 sm:px-10">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-10 pb-10 border-b border-slate-800 text-xs">
                
                <div class="space-y-3">
                    <div class="flex items-center space-x-3">
                        <img src="{{ asset('images/logo.jpg') }}" 
                             alt="Logo" 
                             onerror="this.onerror=null; this.src='https://ui-avatars.com/api/?name=NA&background=ffffff&color=1a3a8f&bold=true';" 
                             class="w-11 h-11 object-contain rounded-full bg-white p-0.5 shadow-md">
                        <div>
                            <span class="font-black text-base tracking-wide uppercase block leading-tight">{{ $institutionName ?? 'NEXO ACADÉMICO' }}</span>
                            <span class="text-[10px] text-blue-400 uppercase font-semibold">Campus Virtual</span>
                        </div>
                    </div>
                    <p class="text-slate-400 leading-relaxed">
                        Entorno virtual de enseñanza y aprendizaje optimizado para la gestión académica y el seguimiento formativo continuo.
                    </p>
                </div>

                <div>
                    <h4 class="font-black uppercase tracking-widest text-sm mb-4 text-white">CONTÁCTANOS</h4>
                    <ul class="space-y-2.5 text-slate-400">
                        <li class="flex items-start space-x-2">
                            <span>📍</span>
                            <span>Sede Central: Campus Institucional</span>
                        </li>
                        <li class="flex items-center space-x-2">
                            <span>📞</span>
                            <span>Teléfono: (043) 31-2026</span>
                        </li>
                        <li class="flex items-center space-x-2">
                            <span>✉️</span>
                            <span>Correo: contacto@osalvac.pe</span>
                        </li>
                    </ul>
                </div>

                <div>
                    <h4 class="font-black uppercase tracking-widest text-sm mb-4 text-white">SÍGUENOS</h4>
                    <div class="flex items-center space-x-3 mb-4">
                        <a href="#" class="w-9 h-9 rounded bg-blue-600 flex items-center justify-center font-bold text-white text-sm hover:bg-blue-500 transition shadow">
                            f
                        </a>
                        <a href="#" class="w-9 h-9 rounded bg-slate-800 border border-slate-700 flex items-center justify-center font-bold text-white text-xs hover:bg-slate-700 transition shadow">
                            𝕏
                        </a>
                        <a href="#" class="w-9 h-9 rounded bg-red-600 flex items-center justify-center font-bold text-white text-xs hover:bg-red-500 transition shadow">
                            ▶
                        </a>
                    </div>
                    <span class="text-xs text-slate-400 block">Horario de soporte: Lunes a Viernes 08:00 a 18:00</span>
                </div>

            </div>

            <div class="pt-6 flex flex-col sm:flex-row items-center justify-between text-xs text-slate-400 gap-2">
                <p>&copy; 2026 <strong>{{ $institutionName ?? 'NEXO ACADÉMICO' }}</strong>. Todos los derechos reservados.</p>
                <div class="flex items-center space-x-4">
                    <a href="#" class="hover:underline">Aviso de Cookies</a>
                    <a href="#" class="hover:underline">Políticas de Privacidad</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- 5. LOGIN MODAL -->
    <div 
        x-show="openLoginModal" 
        x-cloak 
        class="fixed inset-0 z-50 overflow-y-auto flex items-center justify-center bg-black/75 backdrop-blur-sm p-4"
        style="display: none;"
    >
        <div 
            @click.away="openLoginModal = false"
            class="w-full max-w-sm bg-white rounded-2xl shadow-2xl p-6 sm:p-8 relative border border-slate-200"
        >
            <button 
                type="button" 
                @click="openLoginModal = false" 
                class="absolute top-4 right-4 text-gray-400 hover:text-gray-700 w-8 h-8 rounded-full flex items-center justify-center hover:bg-gray-100 transition"
            >
                ✕
            </button>

            <div class="text-center mb-6">
                <img src="{{ asset('images/logo.jpg') }}" 
                     alt="Logo" 
                     onerror="this.onerror=null; this.src='https://ui-avatars.com/api/?name=NA&background=1a3a8f&color=ffffff&bold=true';" 
                     class="w-16 h-16 object-contain rounded-full bg-white p-1 mx-auto mb-2 shadow">
                <h3 class="text-lg font-bold text-gray-900">Acceso al Campus Virtual</h3>
                <p class="text-xs text-gray-500">Ingresa tus credenciales institucionales</p>
            </div>

            @if ($errors->any())
                <div class="mb-4 p-3 rounded-lg bg-red-50 border border-red-200 text-xs text-red-600 font-medium text-center">
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="space-y-4">
                @csrf

                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-1">Correo Electrónico</label>
                    <input 
                        type="email" 
                        name="email" 
                        value="{{ old('email') }}" 
                        required 
                        autofocus 
                        placeholder="ejemplo@osalvac.pe" 
                        class="w-full px-3 py-2.5 border border-gray-300 rounded-lg text-sm focus:outline-none focus:border-blue-600 focus:ring-1 focus:ring-blue-600 placeholder-gray-400"
                    >
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-1">Contraseña</label>
                    <input 
                        type="password" 
                        name="password" 
                        required 
                        placeholder="••••••••" 
                        class="w-full px-3 py-2.5 border border-gray-300 rounded-lg text-sm focus:outline-none focus:border-blue-600 focus:ring-1 focus:ring-blue-600 placeholder-gray-400"
                    >
                </div>

                <div class="flex items-center justify-between text-xs text-gray-600">
                    <label class="flex items-center cursor-pointer">
                        <input type="checkbox" name="remember" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500 mr-2">
                        <span>Recordarme</span>
                    </label>
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="text-blue-700 hover:underline">¿Olvidaste tu clave?</a>
                    @endif
                </div>

                <button 
                    type="submit" 
                    class="w-full bg-blue-700 hover:bg-blue-800 text-white font-bold py-2.5 px-4 rounded-lg text-sm shadow transition duration-150 uppercase tracking-wider mt-2"
                >
                    Ingresar
                </button>
            </form>
        </div>
    </div>

</body>
</html>