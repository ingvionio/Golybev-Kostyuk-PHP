<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Ошибка {{ $statusCode }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
    <div class="bg-white p-8 rounded-lg shadow-md max-w-md w-full">
        <h1 class="text-4xl font-bold text-red-500 mb-4">{{ $statusCode }}</h1>
        <p class="text-gray-700 mb-6">
            Упс! Что-то пошло не так. 
            @if($statusCode == 404)
                Страница не найдена.
            @elseif($statusCode == 403)
                Доступ запрещен.
            @else
                Внутренняя ошибка сервера.
            @endif
        </p>

        @if(session('success'))
            <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
                {{ session('success') }}
            </div>
            <a href="{{ url('/') }}" class="text-blue-500 hover:underline">Вернуться на главную</a>
        @else
            <form action="{{ route('error.report') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="error_message" value="{{ $exception->getMessage() ?: 'Без описания' }}">
                
                <label class="block text-sm font-medium text-gray-700 mb-2">Опишите, что вы делали:</label>
                <textarea name="user_comment" rows="3" class="w-full border-gray-300 rounded-md shadow-sm mb-4" required></textarea>
                
                <label class="block text-sm font-medium text-gray-700 mb-2">Прикрепить скриншот (необязательно):</label>
                <input type="file" name="screenshot" accept=".jpg,.jpeg,.png,.pdf" class="w-full mb-6 text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-red-50 file:text-red-700 hover:file:bg-red-100">
                
                <div class="flex justify-between items-center">
                    <a href="{{ url('/') }}" class="text-sm text-gray-500 hover:underline">На главную</a>
                    <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-md transition">
                        Отправить отчет
                    </button>
                </div>
            </form>
        @endif
    </div>
</body>
</html>