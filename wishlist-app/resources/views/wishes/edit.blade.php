<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Редактировать желание
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 rounded-lg shadow">

                <form action="{{ route('wishes.update', $wish) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PATCH')

                    <input type="text" name="title" placeholder="Название *" required
                        class="w-full border rounded p-2 mb-3" value="{{ old('title', $wish->title) }}">

                    <textarea name="description" placeholder="Описание"
                        class="w-full border rounded p-2 mb-3">{{ old('description', $wish->description) }}</textarea>

                    <input type="url" name="link" placeholder="Ссылка на товар"
                        class="w-full border rounded p-2 mb-3" value="{{ old('link', $wish->link) }}">

                    @if($wish->image)
                        <div class="mb-3">
                            <img src="{{ Storage::url($wish->image) }}" class="w-32 h-32 object-cover rounded">
                            <p class="text-sm text-gray-500 mt-1">Текущее изображение</p>
                        </div>
                    @endif

                    <input type="file" name="image" accept="image/*"
                        class="w-full border rounded p-2 mb-3">

                    <label class="flex items-center gap-2 mb-3">
                        <input type="checkbox" name="is_private" value="1"
                            {{ old('is_private', $wish->is_private) ? 'checked' : '' }}>
                        <span class="text-sm text-gray-600">Приватное (только для друзей)</span>
                    </label>

                    <div class="flex gap-3">
                        <button type="submit"
                            style="background-color: #3b82f6; color: white; padding: 8px 16px; border-radius: 4px;">
                            Сохранить
                        </button>
                        <a href="{{ route('dashboard') }}"
                            style="background-color: #e5e7eb; color: #374151; padding: 8px 16px; border-radius: 4px;">
                            Отмена
                        </a>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>