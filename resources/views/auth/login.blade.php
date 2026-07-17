<x-guest-layout>
    <div class="grid grid-cols-1 md:grid-cols-2 h-screen bg-[#f9f9ff]">

        <!-- Left Section (Form Area) -->
        <div class="flex flex-col justify-center px-8 bg-white">
            <div class="w-full max-w-md mx-auto">

                <!-- Title & Subtitle -->
                <h2 class="text-xl font-semibold text-gray-800 mb-2">Sign-In</h2>
                <p class="text-sm text-gray-500 mb-6">
                    Access the Finovo panel using your email and password.
                </p>

                <!-- Session Status -->
                <x-auth-session-status class="mb-4" :status="session('status')" />

                <!-- Login Form -->
                <form method="POST" action="{{ route('login') }}" class="space-y-6">
                    @csrf

                    <!-- Email -->
                    <div>
                        <div class="flex justify-between items-center mb-1">
                            <x-input-label for="email" :value="__('Email')" />
                            <!-- <a href="#" class="text-xs text-indigo-500 hover:underline">Need Help?</a> -->
                        </div>
                        <x-text-input id="email"
                            class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 px-3 py-2"
                            type="email"
                            name="email"
                            :value="old('email')"
                            placeholder="Your Email"
                            required autofocus autocomplete="username" />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <!-- Password -->
                    <div>
                        <div class="flex justify-between items-center mb-1">
                            <x-input-label for="password" :value="__('Password')" />
                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}" class="text-xs text-indigo-500 hover:underline">Forget Password?</a>
                            @endif
                        </div>
                        <x-text-input id="password"
                            class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 px-3 py-2"
                            type="password"
                            name="password"
                            placeholder="********"
                            required autocomplete="current-password" />
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <!-- Remember Me -->
                    <div class="block">
                        <label for="remember_me" class="inline-flex items-center">
                            <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                            <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                        </label>
                    </div>

                    <!-- Sign In Button -->
                    <button type="submit" 
                        class="w-full bg-indigo-600 hover:bg-indigo-700 focus:ring-4 focus:ring-indigo-300 
                            text-white font-semibold py-3 rounded-lg shadow-md transition duration-200 
                            ease-in-out flex items-center justify-center space-x-2">
                        <span>{{ __('Log in') }}</span>
                        
                    </button>


                    <!-- Register Now Box -->
                    <div class="border border-gray-300 rounded-md text-center py-3">
                        <span class="text-sm text-gray-600">I don’t have an account?</span>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="text-sm font-semibold text-indigo-500 hover:underline ml-1">
                                Register Now!
                            </a>
                        @endif
                    </div>
                </form>

                <!-- Footer Links -->
                <div class="mt-12 text-center text-xs text-gray-400 space-x-4">
                    <a href="https://finovoinvestments.in/term-condition" class="hover:underline px-2" target="_blank">Terms & Conditions</a> |
                    <a href="https://finovoinvestments.in/privacy-policy" class="hover:underline" target="_blank">Privacy Policy</a> 
                </div>

                <!-- Footer Note -->
                <p class="text-center text-xs text-gray-400 mt-2">
                    © 2026 Finovo. All Rights Reserved.
                </p>
            </div>
        </div>

        <!-- Right Section (Illustration + Text) -->
        <div class="bg-indigo-50 flex flex-col justify-center text-center px-8">
            <div class="flex justify-center mb-6">
                <img src="{{ asset('image/login.png') }}" alt="Security Illustration" class="w-64 h-64">
            </div>
            <h3 class="text-xl font-bold text-gray-900">Finovo</h3>
            <p class="text-gray-600 max-w-md mx-auto">
              Finovo is a trusted bot provider giving you access to institutional-grade, automated trading systems. With expert support and intuitive features, we help you succeed in any market with confidence.
            </p>
            <p class="text-indigo-700 font-semibold mt-4">
                Join Finovo today and take control of your financial future.
            </p>
        </div>

    </div>
</x-guest-layout>
