@use('Illuminate\Support\Facades\Storage')
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
                <form action="{{ route('wishes.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="text" name="title" placeholder="Название *" required
                        class="w-full border rounded p-2 mb-3" value="{{ old('title') }}">
                    <textarea name="description" placeholder="Описание"
                        class="w-full border rounded p-2 mb-3">{{ old('description') }}</textarea>
                    <input type="url" name="link" placeholder="Ссылка на товар"
                        class="w-full border rounded p-2 mb-3" value="{{ old('link') }}">
                    <input type="file" name="image" accept="image/*"
                        class="w-full border rounded p-2 mb-3">
                    <label class="flex items-center gap-2 mb-3">
                        <input type="checkbox" name="is_private" value="1">
                        <span class="text-sm text-gray-600">Приватное (только для друзей)</span>
                    </label>
                    <button type="submit"
                        style="background-color: #3b82f6; color: white; padding: 8px 16px; border-radius: 4px;">
                        Добавить
                    </button>
                </form>
            </div>

            {{-- Список желаний --}}
            <div class="bg-white p-6 rounded-lg shadow">
                <h3 class="text-lg font-semibold mb-4">Мои желания</h3>

                @forelse($wishes as $wish)
                    <div class="flex justify-between items-start border-b py-3">
                        <div class="flex gap-4">
                            @if($wish->image)
                                <img src="{{ Storage::url($wish->image) }}" class="w-16 h-16 object-cover rounded">
                            @endif
                            <div>
                                <p class="font-medium">{{ $wish->title }}</p>
                                @if($wish->description)
                                    <p class="text-gray-500 text-sm">{{ $wish->description }}</p>
                                @endif
                                @if($wish->link)
                                    <a href="{{ $wish->link }}" target="_blank"
                                        class="text-blue-500 text-sm">Ссылка на товар</a>
                                @endif
                                <span class="text-xs text-gray-400">
                                    {{ $wish->is_private ? 'Приватное' : 'Публичное' }}
                                </span>
                            </div>
                        </div>
                        <form action="{{ route('wishes.destroy', $wish) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button class="text-red-500 hover:text-red-700 text-sm">Удалить</button>
                        </form>
                        <a href="{{ route('wishes.edit', $wish) }}"style="color: #3b82f6; font-size: 0.875rem; margin-right: 8px;">
                            Редактировать
                        </a>
                    </div>
                @empty
                    <p class="text-gray-500">Список пуст. Добавьте первое желание!</p>
                @endforelse
            </div>

        </div>
    </div>
</x-app-layout>