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
                    <div class="bg-white rounded-lg shadow overflow-hidden">

                        @if($wish->image)
                            <div class="p-4 pb-0">
                                <img src="{{ Storage::url($wish->image) }}"
                                    class="w-32 h-32 object-cover rounded-lg">
                            </div>
                        @endif

                        <div class="p-4">
                            <h3 class="font-semibold text-lg mb-1">{{ $wish->title }}</h3>

                            @if($wish->description)
                                <p class="text-gray-500 text-sm mb-2">{{ $wish->description }}</p>
                            @endif

                            @if($wish->link)
                                <a href="{{ $wish->link }}" target="_blank"
                                    class="text-blue-500 text-sm block mb-2">Ссылка на товар</a>
                            @endif

                            {{-- Автор --}}
                            <div class="flex items-center gap-2 mt-3 pt-3 border-t">
                                @if($wish->user->avatar)
                                    <img src="{{ Storage::url($wish->user->avatar) }}"
                                        class="w-8 h-8 rounded-full object-cover">
                                @else
                                    <div style="width:32px;height:32px;border-radius:50%;background:#e5e7eb;display:flex;align-items:center;justify-content:center;">
                                        <span class="text-gray-400 text-xs">?</span>
                                    </div>
                                @endif
                                <span class="text-sm text-gray-600">{{ $wish->user->name }}</span>
                            </div>
                        </div>

                    </div>
                @empty
                    <p class="text-gray-500 col-span-3">Публичных желаний пока нет.</p>
                @endforelse

            </div>
        </div>
    </div>
</x-app-layout>