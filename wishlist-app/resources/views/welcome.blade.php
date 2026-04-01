<x-guest-layout>
    <div class="relative min-h-screen bg-white dark:bg-gray-900 flex flex-col">
        
        <nav class="fixed top-0 right-0 p-6 flex gap-4 z-20">
            @if (Route::has('login'))
                @auth
                    <a href="{{ route('dashboard') }}" class="px-4 py-2 border-2 border-indigo-600 text-indigo-600 font-black rounded-lg hover:bg-indigo-600 hover:text-white transition shadow-sm">
                        Личный кабинет
                    </a>
                    
                    @can('admin-access')
                        <a href="{{ route('admin.index') }}" class="px-4 py-2 border-2 border-red-600 text-red-600 font-black rounded-lg hover:bg-red-600 hover:text-white transition shadow-sm">
                            Админ-панель
                        </a>
                    @endcan
                @else
                    <a href="{{ route('login') }}" class="px-4 py-2 font-black text-gray-900 dark:text-white hover:text-indigo-600 transition">Войти</a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="px-4 py-2 bg-gray-900 text-white rounded-lg font-black hover:bg-black transition">Регистрация</a>
                    @endif
                @endauth
            @endif
        </nav>

        <div class="flex-grow flex flex-col items-center justify-start pt-20 px-6 text-center">
            
            {{-- ЗАГОЛОВОК: Теперь полностью фиолетовый --}}
            <h1 class="text-7xl md:text-8xl font-black text-indigo-600 mb-6 mt-10 tracking-tighter">
                Wishlist App
            </h1>

            <p class="text-2xl font-bold text-gray-600 dark:text-gray-400 mb-16 max-w-2xl">
                Храни свои мечты. Делись с друзьями. Исполняй желания.
            </p>
            
            <div class="flex flex-col sm:flex-row justify-center items-center gap-10 mt-5">
                
                {{-- КНОПКА ОБЗОРА: Яркий фиолетовый фон (indigo-600) --}}
                <a href="{{ route('wishes.public') }}" class="w-full sm:w-auto bg-indigo-600 text-white px-16 py-6 rounded-2xl font-black text-2xl shadow-2xl hover:bg-indigo-700 hover:scale-105 transition-all uppercase tracking-wider">
                    Обзор желаний
                </a>
                
                @guest
                {{-- Кнопка регистрации: Твоя оригинальная, без изменений --}}
                <a href="{{ route('register') }}" class="w-full sm:w-auto bg-gray-200 text-gray-900 px-16 py-6 rounded-2xl font-black text-2xl hover:bg-gray-300 transition-all uppercase tracking-wider">
                    Регистрация
                </a>
                @endguest
            </div>
        </div>

        <div class="w-full py-6 text-center text-gray-400 font-bold border-t border-gray-100 dark:border-gray-800">
            © 2026 PROJECT WISHLIST
        </div>
    </div>
</x-guest-layout>