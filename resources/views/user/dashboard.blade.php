<x-app-layout>
    <div class="py-8 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-6 bg-green-50 border-l-4 border-green-400 p-4 rounded-lg shadow-sm">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-green-700 font-medium">{{ session('success') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Welcome Section with Banner -->
            <div class="grid grid-cols-1 lg:grid-cols-5 gap-8 mb-8">
                <!-- Left Column - Welcome Text -->
                <div class="lg:col-span-2">
                    <div class="mb-8">
                        <p class="text-gray-600 text-sm mb-2">{{ __('dashboard.welcome') }}</p>
                        <h1 class="text-3xl font-bold text-gray-900 mb-4">{{ __('dashboard.your_dashboard') }}</h1>
                        <p class="text-gray-600 mb-2">{{ __('dashboard.glance_summary') }}</p>
                        <p class="text-gray-600">{{ __('dashboard.have_fun') }}</p>
                    </div>
                </div>

                <!-- Right Column - Promotional Slider (Wider) -->
                <div class="lg:col-span-3">
                    <div class="relative rounded-xl overflow-hidden">
                        <!-- Slider Container -->
                        <div class="slider-container" id="userSlider">
                            <!-- Slide 1 - KYC -->
                            <div class="slide active bg-gradient-to-r from-blue-600 via-purple-600 to-indigo-700 p-6 text-white relative">
                                <div class="relative z-10">
                                    <h3 class="text-xl font-bold mb-2">{{ __('dashboard.complete_kyc') }}</h3>
                                    <p class="text-blue-100 text-sm mb-4">{{ __('dashboard.kyc_description') }}</p>
                                    <button class="bg-white text-blue-600 px-4 py-2 rounded-lg font-semibold text-sm hover:bg-blue-50 transition-colors">
                                        {{ __('dashboard.start_kyc') }}
                                    </button>
                                </div>
                                <div class="absolute right-3 top-3 opacity-20">
                                    <div class="w-24 h-24 bg-white rounded-full flex items-center justify-center">
                                        <i class="fas fa-user-shield text-4xl text-blue-600"></i>
                                    </div>
                                </div>
                            </div>

                            <!-- Slide 2 - Trading -->
                            <div class="slide bg-gradient-to-r from-green-600 via-teal-600 to-cyan-700 p-6 text-white relative">
                                <div class="relative z-10">
                                    <h3 class="text-xl font-bold mb-2">{{ __('dashboard.start_trading') }}</h3>
                                    <p class="text-green-100 text-sm mb-4">{{ __('dashboard.trading_description') }}</p>
                                    <button class="bg-white text-green-600 px-4 py-2 rounded-lg font-semibold text-sm hover:bg-green-50 transition-colors">
                                        {{ __('dashboard.explore_trading') }}
                                    </button>
                                </div>
                                <div class="absolute right-3 top-3 opacity-20">
                                    <div class="w-24 h-24 bg-white rounded-full flex items-center justify-center">
                                        <i class="fas fa-chart-line text-4xl text-green-600"></i>
                                    </div>
                                </div>
                            </div>

                            <!-- Slide 3 - Portfolio -->
                            <div class="slide bg-gradient-to-r from-purple-600 via-pink-600 to-red-700 p-6 text-white relative">
                                <div class="relative z-10">
                                    <h3 class="text-xl font-bold mb-2">{{ __('dashboard.build_portfolio') }}</h3>
                                    <p class="text-purple-100 text-sm mb-4">{{ __('dashboard.portfolio_description') }}</p>
                                    <button class="bg-white text-purple-600 px-4 py-2 rounded-lg font-semibold text-sm hover:bg-purple-50 transition-colors">
                                        {{ __('dashboard.view_portfolio') }}
                                    </button>
                                </div>
                                <div class="absolute right-3 top-3 opacity-20">
                                    <div class="w-24 h-24 bg-white rounded-full flex items-center justify-center">
                                        <i class="fas fa-briefcase text-4xl text-purple-600"></i>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Navigation Dots -->
                        <div class="absolute bottom-4 left-1/2 transform -translate-x-1/2 flex space-x-2">
                            <button class="dot active w-3 h-3 rounded-full bg-white opacity-50" onclick="currentSlide(1, 'userSlider')"></button>
                            <button class="dot w-3 h-3 rounded-full bg-white opacity-30" onclick="currentSlide(2, 'userSlider')"></button>
                            <button class="dot w-3 h-3 rounded-full bg-white opacity-30" onclick="currentSlide(3, 'userSlider')"></button>
                        </div>

                    </div>
                </div>
            </div>

            <!-- Top Row -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
                <!-- User Profile Card -->
                <div class="bg-white rounded-xl shadow-sm p-6">
                    <div class="flex items-center space-x-4">
                        @if(Auth::user()->profile_image_url)
                            <img src="{{ Auth::user()->profile_image_url }}" alt="Profile" class="h-16 w-16 rounded-full object-cover border-2 border-gray-200">
                        @else
                            <div class="h-16 w-16 rounded-full bg-blue-500 flex items-center justify-center text-white text-xl font-bold">
                                {{ Auth::user()->initials }}
                            </div>
                        @endif
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">{{ __('dashboard.wallet_details') }}</h3>
                            <p class="text-gray-600 text-sm mb-6">{{ __('dashboard.your_wallet') }}</p>
                            <p class="text-gray-500 text-sm">{{ Auth::user()->email }} <a href="{{ route('profile.edit') }}" class="text-blue-600 hover:text-blue-800 font-medium"><i class="fas fa-edit"></i>{{ __('dashboard.edit') }}</a></p>
                            <!-- <div class="flex space-x-2 mt-2">
                                <a href="https://web.whatsapp.com/send?phone=919694552255&text=" class="px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition-colors">
                                    {{ __('dashboard.deposit') }}
                                </a>
                                <a href="https://web.whatsapp.com/send?phone=919694552255&text=" class="px-4 py-2 border border-green-500 text-green-600 text-sm font-medium rounded-lg hover:bg-green-50 transition-colors">
                                    {{ __('dashboard.withdraw') }}
                                </a>
                            </div> -->
                        </div>
                    </div>
                </div>

                <!-- Wallet Details -->
                <div class="lg:col-span-2 grid grid-cols-2 md:grid-cols-4 gap-4">
                    <div class="bg-purple-50 p-4 rounded-xl">
                        <p class="text-sm text-gray-500 mb-1">Active Plans</p>
                        <p class="text-xl font-bold">{{ $user->plan->name ?? 'No Plan' }}</p>
                    </div>
                    <div class="bg-blue-50 p-4 rounded-xl">
                        <p class="text-sm text-gray-500 mb-1">Portfolio Value</p>
                        <p class="text-xl font-bold">${{ number_format($user->portfolio_value, 2) }}</p>
                    </div>
                    <div class="bg-green-50 p-4 rounded-xl">
                        <p class="text-sm text-gray-500 mb-1">Growth Rate</p>
                        <p class="text-xl font-bold">{{ number_format($user->total_returns, 2) }}%</p>
                    </div>
                    <div class="bg-yellow-50 p-4 rounded-xl">
                        <p class="text-sm text-gray-500 mb-1">Total Returns</p>
                        <p class="text-xl font-bold">${{ number_format($user->growth_rate, 2) }}</p>
                    </div>
                </div>
            </div>

            @if($user->portfolio_value == 0 && $user->total_returns == 0 && $user->growth_rate == 0)
                <!-- No Data Message -->
                <div class="bg-yellow-50 border-l-4 border-yellow-400 p-6 rounded-lg shadow-md mb-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <svg class="h-6 w-6 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-lg font-medium text-yellow-800">Investment Data Not Available</h3>
                            <p class="mt-2 text-yellow-700">Your investment details haven't been configured yet. Please contact your administrator to set up your investment portfolio.</p>
                        </div>
                    </div>
                </div>
            @else
                <!-- Main Content -->
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    <!-- Left Column -->
                    <div class="lg:col-span-2 space-y-6">
                        <!-- Investment Overview -->
                        <div class="bg-white rounded-xl shadow-sm p-6">
                            <div class="flex justify-between items-center mb-6">
                                <h3 class="text-lg font-semibold">{{ __('dashboard.investment_overview') }}</h3>
                                <div class="flex space-x-2">
                                    <button id="overview-tab" class="tab-button px-3 py-1 text-sm font-medium text-blue-600 bg-blue-50 rounded-lg" data-tab="overview">{{ __('dashboard.overview') }}</button>
                                    <button id="six-months-tab" class="tab-button px-3 py-1 text-sm font-medium text-gray-500 hover:text-gray-700 rounded-lg" data-tab="six-months">{{ __('dashboard.six_months') }}</button>
                                    <button id="one-year-tab" class="tab-button px-3 py-1 text-sm font-medium text-gray-500 hover:text-gray-700 rounded-lg" data-tab="one-year">{{ __('dashboard.one_year') }}</button>
                                </div>
                            </div>
                            
                            <!-- Overview Tab Content -->
                            <div id="overview-content" class="tab-content space-y-4">
                                <div class="flex justify-between items-center p-4 bg-gray-50 rounded-lg">
                                    <div>
                                        <p class="text-sm text-gray-500">Total Amount</p>
                                        <p class="text-xl font-bold">₹{{ number_format($user->portfolio_value, 2) }} <span class="text-green-500 text-sm">+{{ number_format($user->growth_rate, 2) }}%</span></p>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-sm text-gray-500">Current Value</p>
                                        <p class="text-lg font-semibold">₹{{ number_format($user->portfolio_value + $user->total_returns, 2) }}</p>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Six Months Tab Content -->
                            <div id="six-months-content" class="tab-content space-y-4 hidden">
                                @php
                                    $monthlyProfit = $user->portfolio_value * $user->growth_rate / 100; // Monthly profit
                                    $sixMonthProfit = $monthlyProfit * 6; // 6 months of profit
                                    $sixMonthValue = $user->portfolio_value + $sixMonthProfit; // Total after 6 months
                                @endphp
                                <div class="flex justify-between items-center p-4 bg-gray-50 rounded-lg">
                                    <div>
                                        <p class="text-sm text-gray-500">Total Deposit</p>
                                        <p class="text-xl font-bold">₹{{ number_format($user->portfolio_value, 2) }}</p>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-sm text-gray-500">Growth Rate (6 Months)</p>
                                        <p class="text-lg font-semibold">{{ number_format($user->growth_rate * 6, 2) }}%</p>
                                    </div>
                                </div>
                                <div class="p-4 bg-green-50 rounded-lg">
                                    <p class="text-sm text-gray-500">Total Profit (6 Months)</p>
                                    <div class="flex justify-between items-center">
                                        <p class="text-xl font-bold">₹{{ number_format($sixMonthProfit, 2) }}</p>
                                        <span class="text-green-500 font-medium">+{{ number_format($user->growth_rate * 6, 2) }}%</span>
                                    </div>
                                </div>
                                <div class="p-4 bg-indigo-50 rounded-lg">
                                    <p class="text-sm text-gray-500">Total Value (6 Months)</p>
                                    <div class="flex justify-between items-center">
                                        <p class="text-xl font-bold">₹{{ number_format($sixMonthValue, 2) }}</p>
                                        <span class="text-blue-500 font-medium">Deposit + Profit</span>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- One Year Tab Content -->
                            <div id="one-year-content" class="tab-content space-y-4 hidden">
                                @php
                                    $monthlyProfit = $user->portfolio_value * $user->growth_rate / 100; // Monthly profit
                                    $oneYearProfit = $monthlyProfit * 12; // 12 months of profit
                                    $oneYearValue = $user->portfolio_value + $oneYearProfit; // Total after 1 year
                                    $quarterlyProfit = $monthlyProfit * 3; // 3 months profit
                                @endphp
                                <div class="flex justify-between items-center p-4 bg-gray-50 rounded-lg">
                                    <div>
                                        <p class="text-sm text-gray-500">Total Deposit</p>
                                        <p class="text-xl font-bold">₹{{ number_format($user->portfolio_value, 2) }}</p>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-sm text-gray-500">Growth Rate (1 Year)</p>
                                        <p class="text-lg font-semibold">{{ number_format($user->growth_rate * 12, 2) }}%</p>
                                    </div>
                                </div>
                                <div class="p-4 bg-sky-50 rounded-lg">
                                    <p class="text-sm text-gray-500">Total Profit (1 Year)</p>
                                    <div class="flex justify-between items-center">
                                        <p class="text-xl font-bold">₹{{ number_format($oneYearProfit, 2) }}</p>
                                        <span class="text-green-500 font-medium">+{{ number_format($user->growth_rate * 12, 2) }}%</span>
                                    </div>
                                </div>
                                <div class="p-4 bg-indigo-50 rounded-lg">
                                    <p class="text-sm text-gray-500">Total Value (1 Year)</p>
                                    <div class="flex justify-between items-center">
                                        <p class="text-xl font-bold">₹{{ number_format($oneYearValue, 2) }}</p>
                                        <span class="text-blue-500 font-medium">Deposit + Profit</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Right Column -->
                    <div class="space-y-6">
                        <!-- Top Portfolio -->
                        <div class="bg-white rounded-xl shadow-sm p-6">
                            <div class="flex justify-between items-center mb-6">
                                <h3 class="text-lg font-semibold">{{ __('dashboard.top_portfolio') }}</h3>
                            </div>
                            <div class="space-y-4">
                                @foreach([
                                    ['name' => 'OMNI', 'category' => 'fix-flex', 'profit' => 12.5],
                                    ['name' => 'FUINX', 'category' => 'forex', 'profit' => 8.7],
                                    ['name' => 'QUPAI', 'category' => 'crypto', 'profit' => 5.3],
                                    ['name' => 'VAFX', 'category' => 'forex', 'profit' => 3.9],
                                    ['name' => 'VOTX', 'category' => 'crypto', 'profit' => 2.1]
                                ] as $portfolio)
                                <div class="flex items-center justify-between p-3 hover:bg-gray-50 rounded-lg transition-colors">
                                    <div class="flex items-center space-x-3">
                                        <div class="h-10 w-10 rounded-full bg-indigo-100 flex items-center justify-center">
                                            <span class="text-indigo-600 font-medium">{{ substr($portfolio['name'], 0, 1) }}</span>
                                        </div>
                                        <div>
                                            <p class="font-medium">{{ $portfolio['name'] }}</p>
                                            <span class="text-xs px-2 py-0.5 rounded-full {{ 
                                                $portfolio['category'] === 'crypto' ? 'bg-purple-100 text-purple-800' : 
                                                ($portfolio['category'] === 'forex' ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800')
                                            }}">
                                                {{ $portfolio['category'] }}
                                            </span>
                                        </div>
                                    </div>
                                    <div class="flex items-center space-x-4">
                                        <span class="text-green-500 font-medium flex items-center">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18" />
                                            </svg>
                                            {{ $portfolio['profit'] }}%
                                        </span>
                                        <button class="text-sm text-gray-500 hover:text-gray-700">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Tab switching functionality
            const tabButtons = document.querySelectorAll('.tab-button');
            const tabContents = document.querySelectorAll('.tab-content');

            tabButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const targetTab = this.getAttribute('data-tab');
                    
                    // Remove active classes from all buttons
                    tabButtons.forEach(btn => {
                        btn.classList.remove('text-blue-600', 'bg-blue-50');
                        btn.classList.add('text-gray-500');
                    });
                    
                    // Add active classes to clicked button
                    this.classList.remove('text-gray-500');
                    this.classList.add('text-blue-600', 'bg-blue-50');
                    
                    // Hide all tab contents
                    tabContents.forEach(content => {
                        content.classList.add('hidden');
                    });
                    
                    // Show target tab content
                    const targetContent = document.getElementById(targetTab + '-content');
                    if (targetContent) {
                        targetContent.classList.remove('hidden');
                    }
                });
            });
        });
    </script>
</x-app-layout>
