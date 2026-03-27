<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Заявки в друзья
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 rounded-lg shadow">
                <h3 class="text-lg font-semibold mb-4">Входящие заявки</h3>

                @forelse($requests as $request)
                    <div class="flex justify-between items-center border-b py-3">
                        <span>{{ $request->user->name }} ({{ $request->user->email }})</span>
                        <form action="{{ route('friends.accept', $request) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <button class="bg-green-500 text-white px-4 py-1 rounded hover:bg-green-600 text-sm">
                                Принять
                            </button>
                        </form>
                    </div>
                @empty
                    <p class="text-gray-500">Нет входящих заявок.</p>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>