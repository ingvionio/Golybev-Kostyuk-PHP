<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Мои друзья
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- Добавить друга --}}
            <div class="bg-white p-6 rounded-lg shadow">
                <h3 class="text-lg font-semibold mb-4">Добавить друга</h3>
                <form action="{{ route('friends.store') }}" method="POST" class="flex gap-3">
                    @csrf
                    <input type="email" name="email" placeholder="Email пользователя"
                        class="flex-1 border rounded p-2">
                    <button type="submit"
                        class="bg-blue-500 text-white px-6 py-2 rounded hover:bg-blue-600">
                        Отправить заявку
                    </button>
                </form>
                @if(session('success'))
                    <p class="text-green-600 mt-2">{{ session('success') }}</p>
                @endif
                @if(session('error'))
                    <p class="text-red-600 mt-2">{{ session('error') }}</p>
                @endif
            </div>

            {{-- Список друзей --}}
            <div class="bg-white p-6 rounded-lg shadow">
                <h3 class="text-lg font-semibold mb-4">Друзья</h3>
                @forelse($friends as $friendship)
                    @php
                        $friend = $friendship->user_id === auth()->id()
                            ? $friendship->friend
                            : $friendship->user;
                    @endphp
                    <div class="flex justify-between items-center border-b py-3">
                        <span>{{ $friend->name }} ({{ $friend->email }})</span>
                        <a href="{{ route('wishes.show', $friend) }}" class="text-blue-500 text-sm">Смотреть вишлист</a>
                    </div>
                @empty
                    <p class="text-gray-500">У вас пока нет друзей.</p>
                @endforelse
            </div>

        </div>
    </div>
</x-app-layout>