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
                        <h1 class="text-3xl font-bold text-gray-900 mb-4">{{ __('dashboard.admin_dashboard') }}</h1>
                        <p class="text-gray-600 mb-2">{{ __('dashboard.admin_summary') }}</p>
                        <p class="text-gray-600">{{ __('dashboard.manage_users') }}</p>
                    </div>
                </div>

                <!-- Right Column - Admin Slider (Wider) -->
                <div class="lg:col-span-3">
                    <div class="relative rounded-xl overflow-hidden">
                        <!-- Slider Container -->
                        <div class="slider-container" id="adminSlider">
                            <!-- Slide 1 - Analytics -->
                            <div class="slide active bg-green-600 p-6 text-white relative">
                                <div class="relative z-10">
                                    <h3 class="text-xl font-bold mb-2">{{ __('dashboard.platform_analytics') }}</h3>
                                    <p class="text-green-100 text-sm mb-4">{{ __('dashboard.analytics_description') }}</p>
                                    <button class="bg-white text-green-600 px-4 py-2 rounded-lg font-semibold text-sm hover:bg-green-50 transition-colors">
                                        {{ __('dashboard.view_reports') }}
                                    </button>
                                </div>
                                <div class="absolute right-3 top-3 opacity-20">
                                    <div class="w-24 h-24 bg-white rounded-full flex items-center justify-center">
                                        <i class="fas fa-chart-line text-4xl text-green-600"></i>
                                    </div>
                                </div>
                            </div>

                            <!-- Slide 2 - User Management -->
                            <div class="slide bg-blue-600 p-6 text-white relative">
                                <div class="relative z-10">
                                    <h3 class="text-xl font-bold mb-2">{{ __('dashboard.user_management') }}</h3>
                                    <p class="text-blue-100 text-sm mb-4">{{ __('dashboard.user_mgmt_description') }}</p>
                                    <button class="bg-white text-blue-600 px-4 py-2 rounded-lg font-semibold text-sm hover:bg-blue-50 transition-colors">
                                        {{ __('dashboard.manage_users_btn') }}
                                    </button>
                                </div>
                                <div class="absolute right-3 top-3 opacity-20">
                                    <div class="w-24 h-24 bg-white rounded-full flex items-center justify-center">
                                        <i class="fas fa-users text-4xl text-blue-600"></i>
                                    </div>
                                </div>
                            </div>

                            <!-- Slide 3 - System Settings -->
                            <div class="slide bg-orange-600 p-6 text-white relative">
                                <div class="relative z-10">
                                    <h3 class="text-xl font-bold mb-2">{{ __('dashboard.system_settings') }}</h3>
                                    <p class="text-orange-100 text-sm mb-4">{{ __('dashboard.settings_description') }}</p>
                                    <button class="bg-white text-orange-600 px-4 py-2 rounded-lg font-semibold text-sm hover:bg-orange-50 transition-colors">
                                        {{ __('dashboard.settings_btn') }}
                                    </button>
                                </div>
                                <div class="absolute right-3 top-3 opacity-20">
                                    <div class="w-24 h-24 bg-white rounded-full flex items-center justify-center">
                                        <i class="fas fa-cogs text-4xl text-orange-600"></i>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Navigation Dots -->
                        <div class="absolute bottom-4 left-1/2 transform -translate-x-1/2 flex space-x-2">
                            <button class="dot active w-3 h-3 rounded-full bg-white opacity-50" onclick="currentSlide(1, 'adminSlider')"></button>
                            <button class="dot w-3 h-3 rounded-full bg-white opacity-30" onclick="currentSlide(2, 'adminSlider')"></button>
                            <button class="dot w-3 h-3 rounded-full bg-white opacity-30" onclick="currentSlide(3, 'adminSlider')"></button>
                        </div>

                    </div>
                </div>
            </div>

            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
                <!-- User Profile Card -->
                <!-- <div class="bg-white rounded-xl shadow-sm p-6">
                    <div class="flex items-center space-x-4">
                        @if(Auth::user()->profile_image_url)
                            <img src="{{ Auth::user()->profile_image_url }}" alt="Profile" class="h-16 w-16 rounded-full object-cover border-2 border-gray-200">
                        @else
                            <div class="h-16 w-16 rounded-full bg-blue-500 flex items-center justify-center text-white text-xl font-bold">
                                {{ Auth::user()->initials }}
                            </div>
                        @endif
                        <div>
                            <p class="text-sm font-medium text-gray-500">{{ __('dashboard.user_profile') }}</p>
                            <h3 class="text-2xl font-bold text-gray-900">{{ Auth::user()->name }}</h3>
                        </div>
                    </div>
                </div> -->

                <!-- Total Users -->
                <div class="bg-white rounded-xl shadow-sm p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500">{{ __('dashboard.total_users') }}</p>
                            <h3 class="text-2xl font-bold text-gray-900">{{ number_format($totalUsers) }}</h3>
                        </div>
                        <div class="p-3 rounded-lg bg-blue-50">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Total Investment -->
                <div class="bg-white rounded-xl shadow-sm p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500">{{ __('dashboard.active_investments') }}</p>
                            <h3 class="text-2xl font-bold text-gray-900">${{ number_format($totalInvestment, 2) }}</h3>
                        </div>
                        <div class="p-3 rounded-lg bg-green-50">
                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8v8m0-8v8m0-8v8" />
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Total Returns -->
                <div class="bg-white rounded-xl shadow-sm p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500">{{ __('dashboard.total_revenue') }}</p>
                            <h3 class="text-2xl font-bold text-gray-900">${{ number_format($totalReturns, 2) }}</h3>
                        </div>
                        <div class="p-3 rounded-lg bg-purple-50">
                            <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                            </svg>
                        </div>
                    </div>
                </div>


            </div>

            <!-- KYC Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
                <!-- Total KYC -->
                <div class="bg-white rounded-xl shadow-sm p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500">Total KYC</p>
                            <h3 class="text-2xl font-bold text-gray-900">{{ number_format($totalKyc) }}</h3>
                        </div>
                        <div class="p-3 rounded-lg bg-blue-50">
                            <i class="fas fa-id-card text-blue-600 text-xl"></i>
                        </div>
                    </div>
                </div>

                <!-- Pending KYC -->
                <div class="bg-white rounded-xl shadow-sm p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500">Pending KYC</p>
                            <h3 class="text-2xl font-bold text-yellow-600">{{ number_format($pendingKyc) }}</h3>
                        </div>
                        <div class="p-3 rounded-lg bg-yellow-50">
                            <i class="fas fa-clock text-yellow-600 text-xl"></i>
                        </div>
                    </div>
                    @if($pendingKyc > 0)
                    <a href="{{ route('admin.kyc.index', ['status' => 'pending']) }}" class="mt-2 text-xs text-yellow-600 hover:text-yellow-800 font-medium">
                        Review Now →
                    </a>
                    @endif
                </div>

                <!-- Verified KYC -->
                <div class="bg-white rounded-xl shadow-sm p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500">Verified KYC</p>
                            <h3 class="text-2xl font-bold text-green-600">{{ number_format($verifiedKyc) }}</h3>
                        </div>
                        <div class="p-3 rounded-lg bg-green-50">
                            <i class="fas fa-check-circle text-green-600 text-xl"></i>
                        </div>
                    </div>
                </div>

                <!-- Rejected KYC -->
                <div class="bg-white rounded-xl shadow-sm p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500">Rejected KYC</p>
                            <h3 class="text-2xl font-bold text-red-600">{{ number_format($rejectedKyc) }}</h3>
                        </div>
                        <div class="p-3 rounded-lg bg-red-50">
                            <i class="fas fa-times-circle text-red-600 text-xl"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Deposit & Withdrawal Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
                <!-- Total Deposited Amount -->
                <div class="bg-white rounded-xl shadow-sm p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500">Total Deposited</p>
                            <h3 class="text-2xl font-bold text-green-600">${{ number_format($totalDepositedAmount, 2) }}</h3>
                        </div>
                        <div class="p-3 rounded-lg bg-green-50">
                            <i class="fas fa-coins text-green-600 text-xl"></i>
                        </div>
                    </div>
                </div>

                <!-- Pending Deposits -->
                <div class="bg-white rounded-xl shadow-sm p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500">Pending Deposits</p>
                            <h3 class="text-2xl font-bold text-yellow-600">{{ number_format($pendingDeposits) }}</h3>
                        </div>
                        <div class="p-3 rounded-lg bg-yellow-50">
                            <i class="fas fa-wallet text-yellow-600 text-xl"></i>
                        </div>
                    </div>
                    @if($pendingDeposits > 0)
                    <a href="{{ route('admin.deposits.index') }}" class="mt-2 text-xs text-yellow-600 hover:text-yellow-800 font-medium">
                        Review Now →
                    </a>
                    @endif
                </div>

                <!-- Total Withdrawn Amount -->
                <div class="bg-white rounded-xl shadow-sm p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500">Total Withdrawn</p>
                            <h3 class="text-2xl font-bold text-red-600">${{ number_format($totalWithdrawnAmount, 2) }}</h3>
                        </div>
                        <div class="p-3 rounded-lg bg-red-50">
                            <i class="fas fa-hand-holding-usd text-red-600 text-xl"></i>
                        </div>
                    </div>
                </div>

                <!-- Pending Withdrawals -->
                <div class="bg-white rounded-xl shadow-sm p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500">Pending Withdrawals</p>
                            <h3 class="text-2xl font-bold text-yellow-600">{{ number_format($pendingWithdrawals) }}</h3>
                        </div>
                        <div class="p-3 rounded-lg bg-yellow-50">
                            <i class="fas fa-hand-holding-usd text-yellow-600 text-xl"></i>
                        </div>
                    </div>
                    @if($pendingWithdrawals > 0)
                    <a href="{{ route('admin.withdrawals.index') }}" class="mt-2 text-xs text-yellow-600 hover:text-yellow-800 font-medium">
                        Review Now →
                    </a>
                    @endif
                </div>
            </div>

            <!-- Support Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <!-- Total Support Tickets -->
                <div class="bg-white rounded-xl shadow-sm p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500">Support Tickets</p>
                            <h3 class="text-2xl font-bold text-blue-600">{{ number_format($totalTickets) }}</h3>
                        </div>
                        <div class="p-3 rounded-lg bg-blue-50">
                            <i class="fas fa-life-ring text-blue-600 text-xl"></i>
                        </div>
                    </div>
                </div>

                <!-- Pending Tickets -->
                <div class="bg-white rounded-xl shadow-sm p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500">Pending Tickets</p>
                            <h3 class="text-2xl font-bold text-red-600">{{ number_format($pendingTickets) }}</h3>
                        </div>
                        <div class="p-3 rounded-lg bg-red-50">
                            <i class="fas fa-exclamation-circle text-red-600 text-xl"></i>
                        </div>
                    </div>
                    @if($pendingTickets > 0)
                    <a href="{{ route('admin.support.index', ['status' => 'open']) }}" class="mt-2 text-xs text-red-600 hover:text-red-800 font-medium">
                        Reply Now →
                    </a>
                    @endif
                </div>
            </div>

            <!-- Main Content -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Left Column -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Recent Users -->
                    <div class="bg-white rounded-xl shadow-sm p-6">
                        <div class="flex justify-between items-center mb-6">
                            <h3 class="text-lg font-semibold">{{ __('dashboard.recent_users') }}</h3>
                            <a href="{{ route('super-admin.users') }}" class="text-sm text-blue-600 hover:text-blue-800 font-medium">{{ __('dashboard.view_all') }}</a>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('dashboard.name') }}</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('dashboard.email') }}</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('dashboard.joined') }}</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('dashboard.status') }}</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @forelse($recentUsers as $user)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="flex-shrink-0 h-10 w-10 rounded-full bg-blue-100 flex items-center justify-center">
                                                    <span class="text-blue-600 font-medium">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                                                </div>
                                                <div class="ml-4">
                                                    <div class="text-sm font-medium text-gray-900">{{ $user->name }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $user->email }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $user->created_at->format('M d, Y') }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                {{ __('dashboard.active') }}
                                            </span>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="4" class="px-6 py-4 text-center text-sm text-gray-500">{{ __('dashboard.no_users_found') }}</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Recent KYC Applications -->
                    <div class="bg-white rounded-xl shadow-sm p-6">
                        <div class="flex justify-between items-center mb-6">
                            <h3 class="text-lg font-semibold">Recent KYC Applications</h3>
                            <a href="{{ route('admin.kyc.index') }}" class="text-sm text-blue-600 hover:text-blue-800 font-medium">View All</a>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Document Type</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Submitted</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @forelse($recentKyc as $kyc)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="flex-shrink-0 h-10 w-10">
                                                    @if($kyc->user->profile_image_url)
                                                        <img class="h-10 w-10 rounded-full" src="{{ $kyc->user->profile_image_url }}" alt="">
                                                    @else
                                                        <div class="h-10 w-10 rounded-full bg-blue-500 flex items-center justify-center text-white font-semibold">
                                                            {{ $kyc->user->initials }}
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="ml-4">
                                                    <div class="text-sm font-medium text-gray-900">{{ $kyc->user->name }}</div>
                                                    <div class="text-sm text-gray-500">{{ $kyc->user->email }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">{{ $kyc->getDocumentTypeLabel() }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">{{ $kyc->submitted_at?->format('M d, Y') }}</div>
                                            <div class="text-sm text-gray-500">{{ $kyc->submitted_at?->format('h:i A') }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                @if($kyc->status === 'pending') bg-yellow-100 text-yellow-800
                                                @elseif($kyc->status === 'verified') bg-green-100 text-green-800
                                                @else bg-red-100 text-red-800
                                                @endif">
                                                {{ ucfirst($kyc->status) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <a href="{{ route('admin.kyc.show', $kyc->id) }}" 
                                               class="text-blue-600 hover:text-blue-900">
                                                <i class="fas fa-eye mr-1"></i>View
                                            </a>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="5" class="px-6 py-4 text-center text-sm text-gray-500">No KYC applications found</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Recent Deposits -->
                    <div class="bg-white rounded-xl shadow-sm p-6 mt-6">
                        <div class="flex justify-between items-center mb-6">
                            <h3 class="text-lg font-semibold">Recent Deposits</h3>
                            <a href="{{ route('admin.deposits.index') }}" class="text-sm text-blue-600 hover:text-blue-800 font-medium">View All</a>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Network</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @forelse($recentDeposits as $dep)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                                            <div class="font-semibold text-gray-900">{{ $dep->user->name }}</div>
                                            <div class="text-xs text-gray-500">{{ $dep->user->email }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-955">${{ number_format($dep->amount, 2) }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $dep->network }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $dep->created_at->format('M d, Y') }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                @if($dep->status === 'pending') bg-yellow-100 text-yellow-800
                                                @elseif($dep->status === 'approved') bg-green-100 text-green-800
                                                @else bg-red-100 text-red-800
                                                @endif">
                                                {{ ucfirst($dep->status) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <a href="{{ route('admin.deposits.show', $dep->id) }}" class="text-blue-600 hover:text-blue-900">
                                                <i class="fas fa-eye mr-1"></i>View
                                            </a>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="6" class="px-6 py-4 text-center text-sm text-gray-500">No deposits found</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Recent Withdrawals -->
                    <div class="bg-white rounded-xl shadow-sm p-6 mt-6">
                        <div class="flex justify-between items-center mb-6">
                            <h3 class="text-lg font-semibold">Recent Withdrawals</h3>
                            <a href="{{ route('admin.withdrawals.index') }}" class="text-sm text-blue-600 hover:text-blue-800 font-medium">View All</a>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Network</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @forelse($recentWithdrawals as $wth)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                                            <div class="font-semibold text-gray-900">{{ $wth->user->name }}</div>
                                            <div class="text-xs text-gray-500">{{ $wth->user->email }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                                            <div class="font-bold text-gray-900">${{ number_format($wth->amount, 2) }}</div>
                                            <div class="text-xs text-gray-500">+ ${{ number_format($wth->fee, 2) }} fee</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $wth->network }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $wth->created_at->format('M d, Y') }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                @if($wth->status === 'pending') bg-yellow-100 text-yellow-800
                                                @elseif($wth->status === 'approved') bg-green-100 text-green-800
                                                @else bg-red-100 text-red-800
                                                @endif">
                                                {{ ucfirst($wth->status) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <a href="{{ route('admin.withdrawals.show', $wth->id) }}" class="text-blue-600 hover:text-blue-900">
                                                <i class="fas fa-eye mr-1"></i>View
                                            </a>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="6" class="px-6 py-4 text-center text-sm text-gray-500">No withdrawals found</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Recent Support Tickets -->
                    <div class="bg-white rounded-xl shadow-sm p-6 mt-6">
                        <div class="flex justify-between items-center mb-6">
                            <h3 class="text-lg font-semibold">Recent Support Tickets</h3>
                            <a href="{{ route('admin.support.index') }}" class="text-sm text-blue-600 hover:text-blue-800 font-medium">View All</a>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Subject</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @forelse($recentTickets as $ticket)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                                            <div class="font-semibold text-gray-900">{{ $ticket->user->name }}</div>
                                            <div class="text-xs text-gray-500">{{ $ticket->user->email }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-900">{{ $ticket->subject }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $ticket->created_at->format('M d, Y') }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                @if($ticket->status === 'open') bg-yellow-100 text-yellow-800
                                                @else bg-green-100 text-green-800
                                                @endif">
                                                {{ ucfirst($ticket->status) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <a href="{{ route('admin.support.show', $ticket->id) }}" class="text-blue-600 hover:text-blue-900">
                                                <i class="fas fa-reply mr-1"></i>Reply
                                            </a>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="5" class="px-6 py-4 text-center text-sm text-gray-500">No support tickets found</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Right Column -->
                <div class="space-y-6">
                    <!-- KYC Quick Actions -->
                    <div class="bg-blue-600 rounded-xl shadow-sm p-6 text-white">
                        <div class="flex items-center mb-4">
                            <div class="p-3 bg-white bg-opacity-20 rounded-lg">
                                <i class="fas fa-id-card text-2xl"></i>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-lg font-semibold">KYC Management</h3>
                                <p class="text-sm text-blue-100">Review pending applications</p>
                            </div>
                        </div>
                        <div class="space-y-2 mb-4">
                            <div class="flex justify-between items-center">
                                <span class="text-sm">Pending Review</span>
                                <span class="font-bold">{{ $pendingKyc }}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-sm">Total Verified</span>
                                <span class="font-bold">{{ $verifiedKyc }}</span>
                            </div>
                        </div>
                        <a href="{{ route('admin.kyc.index') }}" 
                           class="block w-full text-center bg-white text-blue-600 py-2 rounded-lg font-medium hover:bg-blue-50 transition-colors">
                            Manage All KYC
                        </a>
                    </div>

                    <!-- Top Investors -->
                    <div class="bg-white rounded-xl shadow-sm p-6">
                        <div class="flex justify-between items-center mb-6">
                            <h3 class="text-lg font-semibold">{{ __('dashboard.top_investors') }}</h3>
                        </div>
                        <div class="space-y-4">
                            @forelse($topInvestors as $investor)
                            <div class="flex items-center justify-between p-3 hover:bg-gray-50 rounded-lg transition-colors">
                                <div class="flex items-center space-x-3">
                                    <div class="h-10 w-10 rounded-full bg-indigo-100 flex items-center justify-center">
                                        <span class="text-indigo-600 font-medium">{{ strtoupper(substr($investor->name, 0, 1)) }}</span>
                                    </div>
                                    <div>
                                        <p class="font-medium">{{ $investor->name }}</p>
                                        <p class="text-xs text-gray-500">{{ $investor->email }}</p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <p class="text-sm font-medium">${{ number_format($investor->portfolio_value, 2) }}</p>
                                    <span class="text-xs text-green-500 font-medium">+{{ number_format($investor->growth_rate, 2) }}%</span>
                                </div>
                            </div>
                            @empty
                            <div class="text-center py-4 text-gray-400">
                                <p>{{ __('dashboard.no_investors_data') }}</p>
                            </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
