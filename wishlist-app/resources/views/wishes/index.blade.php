<x-app-layout>
    <div class="max-w-4xl mx-auto p-6">
        @auth
            <form action="{{ route('wishes.store') }}" method="POST" class="mb-8 p-4 bg-gray-50 rounded">
                @csrf
                <input type="text" name="title" placeholder="Что вы хотите?" class="w-full border p-2 mb-2" required>
                <button type="submit" class="bg-green-500 text-white px-4 py-2">Добавить в мой список</button>
            </form>
        @endauth

        <div class="space-y-4">
            @foreach($wishes as $wish)
                <div class="flex justify-between items-center p-4 border rounded shadow-sm">
                    <div>
                        <p class="font-bold text-lg">{{ $wish->title }}</p>
                        <p class="text-sm text-gray-500">Добавил: {{ $wish->user->name }}</p>
                    </div>
                    
                    @can('delete', $wish) [cite: 22]
                        <form action="{{ route('wishes.destroy', $wish) }}" method="POST">
                            @csrf @method('DELETE')
                            <button class="text-red-500 text-sm border border-red-500 px-2 py-1 rounded">Удалить</button>
                        </form>
                    @endcan
                </div>
            @endforeach
        </div>
    </div>
</x-app-layout>