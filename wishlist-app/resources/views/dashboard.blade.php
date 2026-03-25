<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Мой вишлист
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- Форма добавления --}}
            <div class="bg-white p-6 rounded-lg shadow">
                <h3 class="text-lg font-semibold mb-4">Добавить желание</h3>

                <form action="{{ route('wishes.store') }}" method="POST" class="space-y-3">
                    @csrf
                    <input type="text" name="title" placeholder="Название *" required
                        class="w-full border rounded p-2 mb-3" value="{{ old('title') }}">
                    <input type="url" name="link" placeholder="Ссылка на товар"
                        class="w-full border rounded p-2 mb-3" value="{{ old('link') }}">
                    <button type="submit"
                        class="bg-blue-500 text-white px-6 py-2 rounded hover:bg-blue-600 mt-2">
                        Добавить
                    </button>
                </form>
            </div>

            {{-- Список желаний --}}
            <div class="bg-white p-6 rounded-lg shadow">
                <h3 class="text-lg font-semibold mb-4">Мои желания</h3>

                @forelse($wishes as $wish)
                    <div class="flex justify-between items-center border-b py-3">
                        <div>
                            <p class="font-medium">{{ $wish->title }}</p>
                            @if($wish->link)
                                <a href="{{ $wish->link }}" target="_blank"
                                    class="text-blue-500 text-sm">Ссылка на товар</a>
                            @endif
                        </div>
                        <form action="{{ route('wishes.destroy', $wish) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button class="text-red-500 hover:text-red-700 text-sm">Удалить</button>
                        </form>
                    </div>
                @empty
                    <p class="text-gray-500">Список пуст. Добавьте первое желание!</p>
                @endforelse
            </div>

        </div>
    </div>
</x-app-layout>