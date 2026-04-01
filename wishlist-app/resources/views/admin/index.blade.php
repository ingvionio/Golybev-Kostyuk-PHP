<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Админ-панель: Управление пользователями
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b">
                            <th class="py-2">ID</th>
                            <th class="py-2">Имя</th>
                            <th class="py-2">Email</th>
                            <th class="py-2">Роль</th>
                            <th class="py-2">Дата регистрации</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                            <tr class="border-b hover:bg-gray-50">
                                <td class="py-2">{{ $user->id }}</td>
                                <td class="py-2">{{ $user->name }}</td>
                                <td class="py-2">{{ $user->email }}</td>
                                <td class="py-2">
                                    <span class="px-2 py-1 rounded text-xs font-bold 
                                        {{ $user->role->value === 'admin' ? 'bg-red-100 text-red-700' : 
                                           ($user->role->value === 'editor' ? 'bg-blue-100 text-blue-700' : 'bg-gray-100 text-gray-700') }}">
                                        {{ strtoupper($user->role->value) }}
                                    </span>
                                </td>
                                <td class="py-2">{{ $user->created_at->format('d.m.Y') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>