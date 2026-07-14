<x-guest-layout>
    <div class="max-w-md mx-auto bg-white rounded-lg shadow-lg p-8">
        <!-- Heading -->
        <h2 class="text-2xl font-semibold text-gray-800 text-center mb-2">Forgot Password</h2>
        <p class="text-sm text-gray-600 text-center mb-6">
            {{ __('No problem. Just let us know your email address and we will send you a reset link.') }}
        </p>

        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <!-- Form -->
        <form method="POST" action="{{ route('password.email') }}" class="space-y-6">
            @csrf

            <!-- Email Address -->
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">
                    {{ __('Email Address') }}
                </label>
                <input 
                    id="email" 
                    type="email" 
                    name="email" 
                    value="{{ old('email') }}" 
                    required 
                    autofocus 
                    autocomplete="username"
                    placeholder="you@example.com"
                    class="block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm 
                           focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                >
                @error('email')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Submit Button -->
            <div>
                <button type="submit" 
                    class="w-full bg-indigo-500 hover:bg-indigo-600 text-white font-semibold 
                           py-2 rounded-md shadow-md transition duration-150 ease-in-out">
                    {{ __('Send Password Reset Link') }}
                </button>
            </div>

            <!-- Back to login -->
            <div class="text-center mt-4">
                <a href="{{ route('login') }}" class="text-sm text-indigo-600 hover:text-indigo-800 font-medium">
                    {{ __('Back to Login') }}
                </a>
            </div>
        </form>
    </div>
</x-guest-layout>
