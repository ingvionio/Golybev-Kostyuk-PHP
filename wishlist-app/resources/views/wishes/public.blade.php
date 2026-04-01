@use('Illuminate\Support\Facades\Storage')
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Публичные желания
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

                @forelse($wishes as $wish)
                    <div class="bg-white rounded-lg shadow overflow-hidden flex flex-col justify-between">
                        <div>
                            @if($wish->image)
                                <div class="p-4 pb-0">
                                    <img src="{{ Storage::url($wish->image) }}"
                                        class="w-full h-48 object-cover rounded-lg">
                                </div>
                            @endif

                            <div class="p-4">
                                <h3 class="font-semibold text-lg mb-1">{{ $wish->title }}</h3>

                                @if($wish->description)
                                    <p class="text-gray-500 text-sm mb-2">{{ $wish->description }}</p>
                                @endif

                                @if($wish->link)
                                    <a href="{{ $wish->link }}" target="_blank"
                                        class="text-blue-500 text-sm block mb-2 font-medium hover:underline">🔗 Ссылка на товар</a>
                                @endif

                                {{-- Автор --}}
                                <div class="flex items-center gap-2 mt-3 pt-3 border-t">
                                    @if($wish->user->avatar)
                                        <img src="{{ Storage::url($wish->user->avatar) }}"
                                            class="w-8 h-8 rounded-full object-cover">
                                    @else
                                        <div class="w-8 h-8 rounded-full bg-gray-200 flex items-center justify-center">
                                            <span class="text-gray-400 text-[10px]">?</span>
                                        </div>
                                    @endif
                                    <span class="text-sm text-gray-600">{{ $wish->user->name }}</span>
                                </div>
                            </div>
                        </div>

                        {{-- Секция для EDITOR / ADMIN --}}
                        @can('delete', $wish)
                            <div class="p-4 bg-gray-50 border-t flex justify-end">
                                <form action="{{ route('wishes.destroy', $wish) }}" method="POST" onsubmit="return confirm('Вы уверены, что хотите удалить чужое желание как модератор?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 text-xs font-bold uppercase tracking-wider hover:text-red-800">
                                        Удалить (Модерация)
                                    </button>
                                </form>
                            </div>
                        @endcan

                    </div>
                @empty
                    <div class="col-span-3 text-center py-10">
                        <p class="text-gray-500 italic">Публичных желаний пока нет.</p>
                    </div>
                @endforelse

            </div>
        </div>
    </div>
</x-app-layout>