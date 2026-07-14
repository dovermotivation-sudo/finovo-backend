<div class="max-w-4xl mx-auto py-6 sm:px-6 lg:px-8">
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 bg-white border-b border-gray-200">
            <h2 class="text-2xl font-bold text-gray-800 mb-6">{{ __('profile.update_password') }}</h2>
            
            <p class="text-sm text-gray-600 mb-6">
                {{ __('profile.password_security_message') }}
            </p>
            
            <form method="post" action="{{ route('password.update') }}" class="space-y-6">
                @csrf
                @method('put')
                
                <!-- Current Password -->
                <div class="mb-6">
                    <label for="update_password_current_password" class="block text-sm font-medium text-gray-700 mb-1">
                        {{ __('profile.current_password') }}
                    </label>
                    <div class="relative">
                        <input type="password" 
                               id="update_password_current_password" 
                               name="current_password" 
                               class="block w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                               autocomplete="current-password"
                        >
                    </div>
                    @error('current_password', 'updatePassword')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- New Password -->
                <div class="mb-6">
                    <label for="update_password_password" class="block text-sm font-medium text-gray-700 mb-1">
                        {{ __('profile.new_password') }}
                    </label>
                    <div class="relative">
                        <input type="password" 
                               id="update_password_password" 
                               name="password" 
                               class="block w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                               autocomplete="new-password"
                        >
                    </div>
                    @error('password', 'updatePassword')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Confirm Password -->
                <div class="mb-6">
                    <label for="update_password_password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">
                        {{ __('profile.confirm_password') }}
                    </label>
                    <div class="relative">
                        <input type="password" 
                               id="update_password_password_confirmation" 
                               name="password_confirmation" 
                               class="block w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                               autocomplete="new-password"
                        >
                    </div>
                    @error('password_confirmation', 'updatePassword')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Save Button -->
                <div class="flex items-center justify-end pt-4">
                    @if (session('status') === 'password-updated')
                        <p class="mr-4 text-sm text-green-600"
                           x-data="{ show: true }"
                           x-show="show"
                           x-transition
                           x-init="setTimeout(() => show = false, 2000)">
                            {{ __('profile.saved') }}
                        </p>
                    @endif
                    <button type="submit" 
                            class="px-6 py-2 bg-blue-600 text-white font-medium rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        {{ __('profile.save') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
