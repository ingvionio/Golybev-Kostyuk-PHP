@use('Illuminate\Support\Facades\Storage')
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <h2 class="text-lg font-medium text-gray-900 mb-4">Аватарка</h2>

                    <div class="flex items-center gap-6 mb-4">
                        @if(auth()->user()->avatar)
                            <img src="{{ Storage::url(auth()->user()->avatar) }}"
                                class="w-20 h-20 rounded-full object-cover">
                        @else
                            <div style="width:80px;height:80px;border-radius:50%;background:#e5e7eb;display:flex;align-items:center;justify-content:center;">
                                <span class="text-gray-400 text-2xl">?</span>
                            </div>
                        @endif
                    </div>

                    <form action="{{ route('profile.avatar') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="file" name="avatar" accept="image/*"
                            class="w-full border rounded p-2 mb-3">
                        @if(session('status') === 'avatar-updated')
                            <p class="text-green-600 text-sm mb-2">Аватарка обновлена!</p>
                        @endif
                        <button type="submit"
                            style="background-color: #3b82f6; color: white; padding: 8px 16px; border-radius: 4px;">
                            Сохранить аватарку
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
