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
                                    <form action="{{ route('admin.users.role', $user) }}" method="POST">
                                        @csrf @method('PATCH')
                                        <select name="role" onchange="this.form.submit()" class="text-xs border-gray-300 rounded py-1 pl-2 pr-6 {{ $user->role->value === 'admin' ? 'bg-red-50 text-red-700' : ($user->role->value === 'editor' ? 'bg-blue-50 text-blue-700' : 'bg-gray-50 text-gray-700') }}">
                                            <option value="user" {{ $user->role->value === 'user' ? 'selected' : '' }}>USER</option>
                                            <option value="editor" {{ $user->role->value === 'editor' ? 'selected' : '' }}>EDITOR</option>
                                            <option value="admin" {{ $user->role->value === 'admin' ? 'selected' : '' }}>ADMIN</option>
                                        </select>
                                    </form>
                                </td>
                                <td class="py-2">{{ $user->created_at->format('d.m.Y') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- Блок Отчеты об ошибках -->
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 mt-6">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight mb-4">Отчеты об ошибках</h2>
        
        @if(session('success'))
            <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <div class="space-y-4">
            @forelse($reports as $report)
                <div class="border p-4 rounded-lg {{ $report->status === 'resolved' ? 'bg-gray-50' : 'bg-red-50 border-red-200' }}">
                    <div class="flex justify-between items-start mb-2">
                        <div>
                            <span class="font-bold text-sm">
                                От: {{ $report->user_name ?? 'Гость' }} ({{ $report->user_email ?? 'Без email' }})
                            </span>
                            <span class="text-xs text-gray-500 ml-2">{{ $report->created_at }}</span>
                        </div>
                        <span class="px-2 py-1 rounded text-xs font-bold {{ $report->status === 'resolved' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                            {{ strtoupper($report->status) }}
                        </span>
                    </div>

                    <p class="text-sm font-semibold mt-2">Комментарий пользователя:</p>
                    <p class="text-gray-700 mb-2">{{ $report->user_comment }}</p>

                    @if($report->error_message)
                        <p class="text-xs text-gray-400 font-mono bg-gray-100 p-2 rounded mb-2">
                            Системная ошибка: {{ $report->error_message }}
                        </p>
                    @endif

                    @if($report->file_path)
                        <a href="{{ Storage::url($report->file_path) }}" target="_blank" class="text-blue-500 text-sm hover:underline block mb-3">
                            📎 Посмотреть прикрепленный скриншот
                        </a>
                    @endif

                    @if($report->status === 'new')
                        <form action="{{ route('admin.report.reply', $report->id) }}" method="POST" class="mt-4 border-t pt-4">
                            @csrf
                            <textarea name="admin_reply" rows="2" placeholder="Ответить пользователю..." class="w-full text-sm border-gray-300 rounded shadow-sm mb-2" required></textarea>
                            <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-1.5 rounded text-sm">
                                Ответить и закрыть тикет
                            </button>
                        </form>
                    @else
                        <div class="mt-4 border-t pt-4 bg-gray-100 p-3 rounded">
                            <p class="text-sm font-bold text-gray-600">Ваш ответ:</p>
                            <p class="text-gray-800 text-sm">{{ $report->admin_reply }}</p>
                        </div>
                    @endif
                </div>
            @empty
                <p class="text-gray-500">Отчетов об ошибках пока нет.</p>
            @endforelse
        </div>
    </div>
</x-app-layout>