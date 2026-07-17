<x-guest-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Verify Your Email') }}
        </h2>
    </x-slot>

    <div class="py-8 bg-gray-50 min-h-screen flex items-center justify-center">
        <div class="max-w-md w-full bg-white rounded-xl shadow-sm p-8" x-data="{ showChangeEmail: false }">
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

            <!-- OTP Verification Form -->
            <form method="POST" action="{{ route('verification.verify') }}" class="space-y-6" x-show="!showChangeEmail">
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

                <div class="flex flex-col space-y-4">
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
                    
                    <div class="text-center mt-4 pt-4 border-t border-gray-100">
                        <button type="button" @click="showChangeEmail = true" class="text-sm text-gray-500 hover:text-gray-700 underline">
                            Entered the wrong email? Change it here
                        </button>
                    </div>
                </div>
            </form>

            <!-- Change Email Form -->
            <form method="POST" action="{{ route('verification.change-email') }}" class="space-y-6" x-show="showChangeEmail" style="display: none;">
                @csrf

                <div>
                    <x-input-label for="email" :value="__('New Email Address')" />
                    <x-text-input
                        id="email"
                        class="block mt-1 w-full"
                        type="email"
                        name="email"
                        required
                    />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <div class="flex items-center justify-between">
                    <x-primary-button type="submit">
                        {{ __('Update & Resend OTP') }}
                    </x-primary-button>

                    <button type="button" @click="showChangeEmail = false" class="text-sm text-gray-500 hover:text-gray-700">
                        {{ __('Cancel') }}
                    </button>
                </div>
            </form>

            <!-- Hidden form for resend -->
            <form id="resend-form" action="{{ route('verification.resend') }}" method="POST" class="hidden">
                @csrf
            </form>
            
        </div>
    </div>
</x-guest-layout>
