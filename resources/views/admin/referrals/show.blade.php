<x-app-layout>
    <div class="py-8 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Page Header -->
            <div class="mb-6">
                <h1 class="text-3xl font-bold text-gray-900">Referral Details #{{ $referral->id }}</h1>
                <p class="text-gray-600 mt-2">View detailed information about this referral</p>
            </div>
        <!-- Success/Error Messages -->
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Main Info -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Referral Status Card -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-xl font-semibold text-gray-800">Referral Information</h2>
                        @if($referral->status === 'pending')
                            <span class="px-4 py-2 inline-flex text-sm leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                <i class="fas fa-clock mr-2"></i>Pending
                            </span>
                        @elseif($referral->status === 'active')
                            <span class="px-4 py-2 inline-flex text-sm leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                <i class="fas fa-check-circle mr-2"></i>Active
                            </span>
                        @else
                            <span class="px-4 py-2 inline-flex text-sm leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                <i class="fas fa-trophy mr-2"></i>Rewarded
                            </span>
                        @endif
                    </div>

                    <div class="grid grid-cols-2 gap-6">
                        <div>
                            <p class="text-sm text-gray-500 mb-1">Referral Code</p>
                            <p class="text-lg font-semibold text-gray-900">{{ $referral->referral_code }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 mb-1">Referred Date</p>
                            <p class="text-lg font-semibold text-gray-900">{{ $referral->referred_at->format('M d, Y h:i A') }}</p>
                        </div>
                        @if($referral->activated_at)
                        <div>
                            <p class="text-sm text-gray-500 mb-1">Activated Date</p>
                            <p class="text-lg font-semibold text-gray-900">{{ $referral->activated_at->format('M d, Y h:i A') }}</p>
                        </div>
                        @endif
                        @if($referral->rewarded_at)
                        <div>
                            <p class="text-sm text-gray-500 mb-1">Rewarded Date</p>
                            <p class="text-lg font-semibold text-gray-900">{{ $referral->rewarded_at->format('M d, Y h:i A') }}</p>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Referrer Info -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">
                        <i class="fas fa-user-tie mr-2 text-blue-600"></i>Referrer Information
                    </h3>
                    <div class="flex items-center space-x-4">
                        <img src="{{ $referral->referrer->profile_image_url ?? 'https://ui-avatars.com/api/?name=' . urlencode($referral->referrer->name) }}" 
                             alt="{{ $referral->referrer->name }}" 
                             class="w-20 h-20 rounded-full border-2 border-blue-200">
                        <div class="flex-1">
                            <h4 class="text-xl font-semibold text-gray-900">{{ $referral->referrer->name }}</h4>
                            <p class="text-gray-600">{{ $referral->referrer->email }}</p>
                            <p class="text-gray-600">{{ $referral->referrer->phone_number }}</p>
                            <div class="mt-2">
                                <span class="text-sm text-gray-500">Total Referrals: </span>
                                <span class="text-sm font-semibold text-blue-600">{{ $referral->referrer->referrals->count() }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Referred User Info -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">
                        <i class="fas fa-user-plus mr-2 text-green-600"></i>Referred User Information
                    </h3>
                    <div class="flex items-center space-x-4">
                        <img src="{{ $referral->referredUser->profile_image_url ?? 'https://ui-avatars.com/api/?name=' . urlencode($referral->referredUser->name) }}" 
                             alt="{{ $referral->referredUser->name }}" 
                             class="w-20 h-20 rounded-full border-2 border-green-200">
                        <div class="flex-1">
                            <h4 class="text-xl font-semibold text-gray-900">{{ $referral->referredUser->name }}</h4>
                            <p class="text-gray-600">{{ $referral->referredUser->email }}</p>
                            <p class="text-gray-600">{{ $referral->referredUser->phone_number }}</p>
                            <div class="mt-2 flex items-center space-x-4">
                                <div>
                                    <span class="text-sm text-gray-500">KYC Status: </span>
                                    @if($referral->referredUser->hasVerifiedKyc())
                                        <span class="text-sm font-semibold text-green-600">
                                            <i class="fas fa-check-circle"></i> Verified
                                        </span>
                                    @else
                                        <span class="text-sm font-semibold text-yellow-600">
                                            <i class="fas fa-clock"></i> Pending
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Rewards Info -->
                @if($referral->rewards->count() > 0)
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">
                        <i class="fas fa-gift mr-2 text-purple-600"></i>Rewards Issued
                    </h3>
                    <div class="space-y-4">
                        @foreach($referral->rewards as $reward)
                        <div class="border border-gray-200 rounded-lg p-4">
                            <div class="flex items-center justify-between">
                                <div class="flex-1">
                                    <div class="flex items-center space-x-3">
                                        @if($reward->status === 'credited')
                                            <div class="bg-green-100 rounded-full p-2">
                                                <i class="fas fa-check-circle text-green-600"></i>
                                            </div>
                                        @elseif($reward->status === 'pending')
                                            <div class="bg-yellow-100 rounded-full p-2">
                                                <i class="fas fa-clock text-yellow-600"></i>
                                            </div>
                                        @else
                                            <div class="bg-red-100 rounded-full p-2">
                                                <i class="fas fa-times-circle text-red-600"></i>
                                            </div>
                                        @endif
                                        <div>
                                            <h4 class="font-semibold text-gray-900">{{ $reward->user->name }}</h4>
                                            <p class="text-sm text-gray-600">{{ $reward->reward_description }}</p>
                                            <p class="text-xs text-gray-500 mt-1">
                                                Type: {{ ucfirst($reward->reward_type) }} | 
                                                {{ $reward->created_at->format('M d, Y h:i A') }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <p class="text-2xl font-bold text-gray-900">${{ number_format($reward->reward_amount, 2) }}</p>
                                    @if($reward->status === 'credited')
                                        <span class="text-xs text-green-600 font-medium">Credited</span>
                                    @elseif($reward->status === 'pending')
                                        <span class="text-xs text-yellow-600 font-medium">Pending</span>
                                    @else
                                        <span class="text-xs text-red-600 font-medium">Cancelled</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>

            <!-- Actions Sidebar -->
            <div class="space-y-6">
                <!-- Quick Stats -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Quick Stats</h3>
                    <div class="space-y-4">
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-600">Total Rewards</span>
                            <span class="text-lg font-bold text-purple-600">${{ number_format($referral->rewards->sum('reward_amount'), 2) }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-600">Credited</span>
                            <span class="text-lg font-bold text-green-600">${{ number_format($referral->rewards->where('status', 'credited')->sum('reward_amount'), 2) }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-600">Pending</span>
                            <span class="text-lg font-bold text-yellow-600">${{ number_format($referral->rewards->where('status', 'pending')->sum('reward_amount'), 2) }}</span>
                        </div>
                    </div>
                </div>

                <!-- Actions -->
                @if($referral->status !== 'rewarded')
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Actions</h3>
                    <form action="{{ route('admin.referrals.process-reward', $referral->id) }}" method="POST">
                        @csrf
                        <button type="submit" 
                                class="w-full bg-green-600 text-white px-4 py-3 rounded-lg hover:bg-green-700 transition-colors"
                                onclick="return confirm('Are you sure you want to process rewards for this referral?')">
                            <i class="fas fa-gift mr-2"></i>Process Reward
                        </button>
                    </form>
                    <p class="text-xs text-gray-500 mt-2 text-center">
                        This will create and credit rewards for both users
                    </p>
                </div>
                @endif

                <!-- Timeline -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Timeline</h3>
                    <div class="space-y-4">
                        <div class="flex items-start">
                            <div class="bg-blue-100 rounded-full p-2 mr-3">
                                <i class="fas fa-user-plus text-blue-600 text-sm"></i>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-900">User Registered</p>
                                <p class="text-xs text-gray-500">{{ $referral->referred_at->format('M d, Y h:i A') }}</p>
                            </div>
                        </div>
                        
                        @if($referral->activated_at)
                        <div class="flex items-start">
                            <div class="bg-green-100 rounded-full p-2 mr-3">
                                <i class="fas fa-check-circle text-green-600 text-sm"></i>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-900">Referral Activated</p>
                                <p class="text-xs text-gray-500">{{ $referral->activated_at->format('M d, Y h:i A') }}</p>
                            </div>
                        </div>
                        @endif
                        
                        @if($referral->rewarded_at)
                        <div class="flex items-start">
                            <div class="bg-purple-100 rounded-full p-2 mr-3">
                                <i class="fas fa-trophy text-purple-600 text-sm"></i>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-900">Rewards Processed</p>
                                <p class="text-xs text-gray-500">{{ $referral->rewarded_at->format('M d, Y h:i A') }}</p>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
