<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Вишлист {{ $user->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 rounded-lg shadow">

                @forelse($wishes as $wish)
                    <div class="flex justify-between items-start border-b py-3">
                        <div>
                            <p class="font-medium">{{ $wish->title }}</p>
                            @if($wish->link)
                                <a href="{{ $wish->link }}" target="_blank"
                                    class="text-blue-500 text-sm">Ссылка на товар</a>
                            @endif
                            <span class="text-sm px-2 py-1 rounded
                                @if($wish->status === 'open') bg-green-100 text-green-700
                                @elseif($wish->status === 'reserved') bg-yellow-100 text-yellow-700
                                @else bg-gray-100 text-gray-700 @endif">
                                @if($wish->status === 'open') Никто не выполняет
                                @elseif($wish->status === 'reserved') Выполняется
                                @else Исполнено @endif
                            </span>
                        </div>
                        <div class="flex gap-2">
                            @if($wish->status === 'open')
                                <form action="{{ route('wishes.reserve', $wish) }}" method="POST">
                                    @csrf @method('PATCH')
                                    <button class="bg-blue-500 text-white px-3 py-1 rounded text-sm">
                                        Взять
                                    </button>
                                </form>
                            @elseif($wish->status === 'reserved' && $wish->reserved_by === auth()->id())
                                <form action="{{ route('wishes.fulfill', $wish) }}" method="POST">
                                    @csrf @method('PATCH')
                                    <button class="bg-green-500 text-white px-3 py-1 rounded text-sm">
                                        Исполнено
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                @empty
                    <p class="text-gray-500">Список желаний пуст.</p>
                @endforelse

            </div>
        </div>
    </div>
</x-app-layout>