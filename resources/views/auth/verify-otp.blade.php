<x-guest-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Verify Your Email') }}
        </h2>
    </x-slot>

    <div class="py-8 bg-gray-50 min-h-screen flex items-center justify-center">
        <div class="max-w-md w-full bg-white rounded-xl shadow-sm p-8">
            <div class="mb-6 text-center">
                <h2 class="text-2xl font-bold text-gray-900">Verify Your Email</h2>
                <p class="mt-2 text-sm text-gray-600">
                    We've sent a 6-digit verification code to your email address.
                </p>
            </div>

            @if (session('status'))
                <div class="mb-4 text-sm font-medium text-green-600">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('verification.verify') }}" class="space-y-6">
                @csrf

                <!-- OTP Input -->
                <div>
                    <x-input-label for="otp" :value="__('Verification Code')" />
                    <x-text-input
                        id="otp"
                        class="block mt-1 w-full text-center text-xl tracking-widest"
                        type="text"
                        name="otp"
                        inputmode="numeric"
                        pattern="[0-9]*"
                        maxlength="6"
                        required
                        autofocus
                        autocomplete="one-time-code"
                    />
                    <x-input-error :messages="$errors->get('otp')" class="mt-2" />
                </div>

                <div class="flex items-center justify-between">
                    <x-primary-button type="submit">
                        {{ __('Verify') }}
                    </x-primary-button>

                    <a 
                        href="{{ route('verification.resend') }}" 
                        class="text-sm text-indigo-600 hover:text-indigo-500"
                        onclick="event.preventDefault(); document.getElementById('resend-form').submit();"
                    >
                        {{ __('Resend Code') }}
                    </a>
                </div>
            </form>

            <!-- Hidden form for resend -->
            <form id="resend-form" action="{{ route('verification.resend') }}" method="POST" class="hidden">
                @csrf
            </form>

            
        </div>
    </div>
</x-guest-layout>
