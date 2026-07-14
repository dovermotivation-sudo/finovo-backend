<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center px-4 sm:px-6 lg:px-8">
        <div class="max-w-5xl w-full bg-white rounded-xl shadow-xl overflow-hidden grid grid-cols-1 md:grid-cols-2">

            <!-- Left Side - Register Form -->
            <div class="p-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-2">Register Account</h2>
                <p class="text-gray-600 mb-6">Create your account to access the Finovo Investment panel.</p>

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

                    <!-- Plan Tabs -->
                    <div>
                        <div class="flex justify-between items-center mb-2">
                            <label class="block text-sm font-medium text-gray-700">Select a Plan</label>
                        </div>
                        <div class="flex space-x-2 border-b mb-4">
                            <!--<button type="button" class="tab-btn px-4 py-2 -mb-px font-medium border-b-2 border-indigo-500 text-indigo-600" data-tab="flexible">Flexible Investment Packages</button>-->
                            <button type="button" class="tab-btn px-4 py-2 -mb-px font-medium border-b-2 border-transparent text-gray-500" data-tab="smart">Smart Bot Packages</button>
                        </div>

                        <!--<div id="flexible" class="tab-content space-y-3">-->
                        <!--    @foreach ($plans->where('plan_type', 'Flexible Investment Packages') as $plan)-->
                        <!--        <label for="plan-{{ $plan->id }}" class="block cursor-pointer">-->
                        <!--            <input type="radio" id="plan-{{ $plan->id }}" name="plan_id" value="{{ $plan->id }}" class="hidden peer" {{ old('plan_id') == $plan->id ? 'checked' : '' }}>-->
                        <!--            <div class="p-4 border rounded-lg hover:shadow-md transition duration-200 peer-checked:border-indigo-500 peer-checked:ring-2 peer-checked:ring-indigo-200">-->
                        <!--                <div class="flex items-start">-->
                        <!--                    <div class="flex items-center h-5">-->
                        <!--                        <div class="w-5 h-5 border-2 border-gray-300 rounded-full flex items-center justify-center mr-3 peer-checked:bg-indigo-500 peer-checked:border-indigo-500">-->
                        <!--                            <svg class="w-3 h-3 text-white hidden peer-checked:block" fill="none" viewBox="0 0 24 24" stroke="currentColor">-->
                        <!--                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />-->
                        <!--                            </svg>-->
                        <!--                        </div>-->
                        <!--                    </div>-->
                        <!--                    <div>-->
                        <!--                        <h3 class="font-semibold text-gray-900">{{ $plan->name }}</h3>-->
                        <!--                        <p class="text-sm text-gray-600 mt-1"><strong>ROI:</strong> {{ $plan->roi }}</p>-->
                        <!--                        <p class="text-sm text-gray-600"><strong>Min Investment:</strong> {{ $plan->minimum_investment }}</p>-->
                        <!--                        <p class="text-sm text-gray-600 mt-2">{{ $plan->description }}</p>-->
                        <!--                    </div>-->
                        <!--                </div>-->
                        <!--            </div>-->
                        <!--        </label>-->
                        <!--    @endforeach-->
                        <!--</div>-->

                        <div id="smart" class="tab-content hidden space-y-3">
                            @foreach ($plans->where('plan_type', 'Smart Bot Packages') as $plan)
                                <label for="plan-{{ $plan->id }}" class="block cursor-pointer">
                                    <input type="radio" id="plan-{{ $plan->id }}" name="plan_id" value="{{ $plan->id }}" class="hidden peer" {{ old('plan_id') == $plan->id ? 'checked' : '' }}>
                                    <div class="p-4 border rounded-lg hover:shadow-md transition duration-200 peer-checked:border-indigo-500 peer-checked:ring-2 peer-checked:ring-indigo-200">
                                        <div class="flex items-start">
                                            <div class="flex items-center h-5">
                                                <div class="w-5 h-5 border-2 border-gray-300 rounded-full flex items-center justify-center mr-3 peer-checked:bg-indigo-500 peer-checked:border-indigo-500">
                                                    <svg class="w-3 h-3 text-white hidden peer-checked:block" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                                    </svg>
                                                </div>
                                            </div>
                                            <div>
                                                <h3 class="font-semibold text-gray-900">{{ $plan->name }}</h3>
                                                <p class="text-sm text-gray-600 mt-1"><strong>ROI:</strong> {{ $plan->roi }}</p>
                                                <p class="text-sm text-gray-600"><strong>Min Investment:</strong> {{ $plan->minimum_investment }}</p>
                                                <p class="text-sm text-gray-600 mt-2">{{ $plan->description }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </label>
                            @endforeach
                        </div>
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
                <h3 class="text-xl font-bold text-gray-900">Finovo Investment</h3>
                <p class="text-gray-600">
                    Finovo Trading is a trusted bot provider giving you access to institutional-grade, automated trading systems. With expert support and intuitive features, we help you succeed in any market with confidence.
                </p>
                <p class="text-indigo-700 font-semibold">Join Finovo Investment today and take control of your financial future.</p>
            </div>
        </div>
    </div>

    <!-- jQuery for tab switching -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script>
        $(document).ready(function () {
    // Tab switching
    $('.tab-btn').click(function () {
        var tab = $(this).data('tab');
        $('.tab-btn')
            .removeClass('border-indigo-500 text-indigo-600')
            .addClass('border-transparent text-gray-500');
        $(this)
            .addClass('border-indigo-500 text-indigo-600')
            .removeClass('border-transparent text-gray-500');
        $('.tab-content').addClass('hidden');
        $('#' + tab).removeClass('hidden');
    });

    // Form validation
    $('form').on('submit', function (e) {
        let isValid = true;
        const planSelected = $('input[name="plan_id"]:checked').length > 0;
        const termsChecked = $('#terms').is(':checked');

        // Reset states
        $('label[for^="plan-"] > div')
            .removeClass('border-red-500 ring-2 ring-red-200');

        // Validate plan selection
        if (!planSelected) {
            $('.tab-content:not(.hidden) label > div')
                .addClass('border-red-500 ring-2 ring-red-200');
            isValid = false;
        }

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

    // Clear error when selecting a plan
    $('input[name="plan_id"]').on('change', function () {
        $('label[for^="plan-"] > div')
            .removeClass('border-red-500 ring-2 ring-red-200');
    });

    // Clear error when checking terms
    $('#terms').on('change', function () {
        $(this).closest('div').removeClass('text-red-600');
    });

    // Handle label click manually
    $('label[for^="plan-"]').on('click', function (e) {
        e.preventDefault();
        const radioId = $(this).attr('for');
        $('#' + radioId).prop('checked', true).trigger('change');
    });

    // Handle radio button change (update design)
    $('input[name="plan_id"]').on('change', function () {
        $('label[for^="plan-"] > div')
            .removeClass('border-indigo-500 bg-indigo-50')
            .addClass('border-gray-200');

        $('label[for^="plan-"] .rounded-full')
            .removeClass('border-indigo-700 bg-indigo-700')
            .addClass('border-gray-400')
            .find('svg')
            .hide();

        if ($(this).is(':checked')) {
            const $label = $('label[for="' + $(this).attr('id') + '"]');
            $label.find('> div')
                .addClass('border-indigo-500 bg-indigo-50')
                .removeClass('border-gray-200');
            $label.find('.rounded-full')
                .addClass('border-indigo-700 bg-indigo-700')
                .removeClass('border-gray-400')
                .find('svg')
                .show();
        }
    });

    // Initialize
    $('input[name="plan_id"]:checked').trigger('change');

    // --- NEW CODE: Select plan from URL ---
    (function selectPlanFromURL() {
        const urlParams = new URLSearchParams(window.location.search);
        const planName = urlParams.get('plan'); // Example: ?plan=Plan%20A

        if (!planName) return;

        const $planInput = $('input[name="plan_id"]').filter(function () {
            return $(this).siblings('div').find('h3').text().trim() === planName;
        });

        if ($planInput.length) {
            // Check the radio button
            $planInput.prop('checked', true).trigger('change');

            // Switch tab if necessary
            const tabType = $planInput.closest('.tab-content').attr('id');
            $('.tab-btn')
                .removeClass('border-indigo-500 text-indigo-600')
                .addClass('border-transparent text-gray-500');
            $('.tab-btn[data-tab="' + tabType + '"]')
                .addClass('border-indigo-500 text-indigo-600')
                .removeClass('border-transparent text-gray-500');

            $('.tab-content').addClass('hidden');
            $('#' + tabType).removeClass('hidden');
        }
    })();
});

    </script>
</x-guest-layout>