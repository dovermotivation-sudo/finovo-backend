<x-guest-layout>
    <div class="py-6 flex items-center justify-center px-4 sm:px-6 lg:px-8">
        <div class="max-w-5xl w-full bg-white rounded-xl shadow-xl overflow-hidden grid grid-cols-1 md:grid-cols-2">

            <!-- Left Side - Register Form -->
            <div class="p-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-2">Register Account</h2>
                <p class="text-gray-600 mb-6">Create your account to access the Finovo panel.</p>

                @if ($errors->any())
                    <div class="mb-4 bg-red-50 border-l-4 border-red-400 p-4 rounded">
                        <ul class="text-sm text-red-700 list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('register') }}" class="space-y-4">
                    @csrf

                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700">Full Name</label>
                        <input id="name" name="name" type="text" required autofocus
                            class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500" value="{{ old('name') }}">
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                        <input id="email" name="email" type="email" required
                            class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500" value="{{ old('email') }}">
                    </div>

                    <div>
                    <label for="phone" class="block text-sm font-medium text-gray-700">
                        Phone Number
                    </label>
                    <div class="mt-1 flex rounded-lg shadow-sm">
                        <!-- Indian Flag Prefix -->
                        <span class="inline-flex items-center px-3 rounded-l-lg border border-r-0 border-gray-300 bg-gray-50 text-gray-700 text-sm">
                        <img src="{{asset('image/india_flag.png')}}" alt="India Flag" class="w-5 h-5 mr-2">  +91 
                        </span>

                        <!-- Phone Input -->
                        <input id="phone" name="phone_number" type="tel" required
                            inputmode="numeric" 
                            pattern="[6-9][0-9]{9}" 
                            title="Enter a valid 10-digit Indian phone number"
                            maxlength="10"
                            oninput="this.value=this.value.replace(/[^0-9]/g,'').slice(0,10)"
                            class="flex-1 block w-full rounded-r-lg border-gray-300 focus:ring-indigo-500 focus:border-indigo-500"
                            placeholder="9876543210"
                            value="{{ old('phone_number') }}">
                    </div>
                </div>

                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                        <input id="password" name="password" type="password" required
                            class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                    </div>

                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirm Password</label>
                        <input id="password_confirmation" name="password_confirmation" type="password" required
                            class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                    </div>

                    <!-- Referral Code (Optional) -->
                    <div>
                        <label for="referral_code" class="block text-sm font-medium text-gray-700">
                            Referral Code <span class="text-gray-500 text-xs">(Optional)</span>
                        </label>
                        <input id="referral_code" name="referral_code" type="text" 
                            class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500" 
                            value="{{ old('referral_code', $referralCode ?? '') }}"
                            placeholder="Enter referral code if you have one">
                        @error('referral_code')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>


                    <!-- Terms -->
                    <div class="flex items-center">
                        <input id="terms" name="terms" type="checkbox" required
                            class="h-4 w-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                        <label for="terms" class="ml-2 block text-sm text-gray-700">
                            I agree to the <a href="https://finovoinvestments.in/term-condition" class="text-indigo-600 hover:underline" target="_blank">Terms & Conditions</a> and <a href="https://finovoinvestments.in/privacy-policy" class="text-indigo-600 hover:underline" target="_blank">Privacy Policy</a>
                        </label>
                    </div>

                    <div>
                        <button type="submit"
                            class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2 px-4 rounded-lg shadow-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
                            Create Account
                        </button>
                    </div>

                    <p class="text-center text-sm text-gray-600">
                        Already have an account?
                        <a href="{{ route('login') }}" class="text-indigo-600 hover:underline">Sign In</a>
                    </p>
                </form>
            </div>

            <!-- Right Side - Illustration -->
            <div class="bg-indigo-50 p-8 flex flex-col justify-center text-center space-y-4">
                <div class="flex justify-center mb-4">
                    <img src="{{ asset('image/register.png') }}" alt="Security Illustration" class="w-64 h-64">
                </div>
                <h3 class="text-xl font-bold text-gray-900">Finovo</h3>
                <p class="text-gray-600">
                    Finovo is a trusted bot provider giving you access to institutional-grade, automated trading systems. With expert support and intuitive features, we help you succeed in any market with confidence.
                </p>
                <p class="text-indigo-700 font-semibold">Join Finovo today and take control of your financial future.</p>
            </div>
        </div>
    </div>

    <!-- jQuery for tab switching -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script>
        $(document).ready(function () {
        // Form validation
    $('form').on('submit', function (e) {
        let isValid = true;
        const termsChecked = $('#terms').is(':checked');

        // Validate terms
        if (!termsChecked) {
            $('#terms').closest('div').addClass('text-red-600');
            isValid = false;
        } else {
            $('#terms').closest('div').removeClass('text-red-600');
        }

        if (!isValid) {
            e.preventDefault();            
        }
    });

    // Clear error when checking terms
    $('#terms').on('change', function () {
        $(this).closest('div').removeClass('text-red-600');
    });
});

    </script>
</x-guest-layout>