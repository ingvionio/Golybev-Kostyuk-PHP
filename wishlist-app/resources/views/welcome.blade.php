<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Wishlist App') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased bg-gray-50 text-gray-900 font-sans">
    <div class="relative min-h-screen flex flex-col">
        
        <!-- Навигация (Верхний правый угол) -->
        <nav class="absolute top-0 right-0 p-6 flex items-center gap-4 z-20">
            @if (Route::has('login'))
                @auth
                    <a href="{{ route('dashboard') }}" class="px-1.5 py-2 border-2 border-indigo-600 text-indigo-600 font-bold rounded-lg hover:bg-indigo-600 hover:text-white transition shadow-sm">
                        Личный кабинет
                    </a>
                    
                    @can('admin-access')
                        <a href="{{ route('admin.index') }}" class="px-5 py-2 border-2 border-red-600 text-red-600 font-bold rounded-lg hover:bg-red-600 hover:text-white transition shadow-sm">
                            Админ-панель
                        </a>
                    @endcan
                @else
                    <a href="{{ route('login') }}" class="px-5 py-2 font-bold text-gray-600 hover:text-indigo-600 transition">
                        Войти
                    </a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="px-6 py-3 bg-gray-900 text-white rounded-lg font-bold hover:bg-black transition shadow-sm">
                            Регистрация
                        </a>
                    @endif
                @endauth
            @endif
        </nav>

        <!-- Основной контент страницы -->
        <div class="flex-grow flex flex-col items-center justify-center px-6 text-center">
            
            <h1 class="text-6xl md:text-8xl font-black text-indigo-600 mb-6 tracking-tighter">
                Wishlist App
            </h1>

            <p class="text-xl md:text-2xl font-medium text-gray-600 mb-12 max-w-2xl">
                Храни свои мечты. Делись с друзьями. Исполняй желания.
            </p>
            
            <!-- Большие кнопки действий -->
            <div class="flex flex-col sm:flex-column justify-center items-center gap-6 w-full max-w-lg mt-4" style="max-width: 30vw;">
                
                <a href="{{ route('wishes.public') }}" class="w-full sm:w-1/2 flex justify-center items-center bg-indigo-600 text-white px-8 py-4 rounded-xl font-bold text-lg shadow-lg hover:bg-indigo-700 hover:-translate-y-1 transition-all uppercase tracking-wide">
                    Обзор желаний
                </a>
                
                @guest
                <a href="{{ route('register') }}" class="w-full sm:w-1/2 flex justify-center items-center bg-white border-2 border-gray-200 text-gray-800 px-8 py-4 rounded-xl font-bold text-lg shadow hover:bg-gray-50 hover:-translate-y-1 transition-all uppercase tracking-wide">
                    Регистрация
                </a>
                @endguest

            </div>
        </div>

        <!-- Футер -->
        <div class="w-full py-6 text-center text-gray-400 font-bold border-t border-gray-200">
            © 2026 PROJECT WISHLIST
        </div>
    </div>
</body>
</html>