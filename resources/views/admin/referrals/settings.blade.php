<x-app-layout>
    <div class="py-8 bg-gray-50 min-h-screen">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Page Header -->
            <div class="mb-6">
                <h1 class="text-3xl font-bold text-gray-900">Referral Settings</h1>
                <p class="text-gray-600 mt-2">Configure referral system parameters and rewards</p>
            </div>
        <!-- Success/Error Messages -->
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                <i class="fas fa-exclamation-circle mr-2"></i>{{ session('error') }}
            </div>
        @endif

        <!-- Settings Form -->
        <div class="bg-white rounded-lg shadow-md">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-xl font-semibold text-gray-800">Configure Referral System</h2>
                <p class="text-sm text-gray-600 mt-1">Manage reward criteria, amounts, and system settings</p>
            </div>

            <form action="{{ route('admin.referrals.settings.update') }}" method="POST" class="p-6 space-y-6">
                @csrf

                <!-- Enable/Disable Referral System -->
                <div class="border-b border-gray-200 pb-6">
                    <label class="flex items-center justify-between cursor-pointer">
                        <div>
                            <h3 class="text-lg font-medium text-gray-900">Enable Referral System</h3>
                            <p class="text-sm text-gray-500">Turn the referral program on or off</p>
                        </div>
                        <div class="relative">
                            <input type="checkbox" name="referral_enabled" value="1" 
                                   {{ $settings['referral_enabled']->value == '1' ? 'checked' : '' }}
                                   class="sr-only peer">
                            <div class="w-14 h-8 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-1 after:left-1 after:bg-white after:border-gray-300 after:border after:rounded-full after:h-6 after:w-6 after:transition-all peer-checked:bg-blue-600"></div>
                        </div>
                    </label>
                </div>

                <!-- Reward Criteria -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-clipboard-check mr-2 text-blue-600"></i>Reward Criteria
                    </label>
                    <select name="reward_criteria" required class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-blue-500">
                        <option value="registration" {{ $settings['reward_criteria']->value == 'registration' ? 'selected' : '' }}>
                            Upon Registration (Immediate)
                        </option>
                        <option value="kyc_approved" {{ $settings['reward_criteria']->value == 'kyc_approved' ? 'selected' : '' }}>
                            After KYC Approval (Recommended)
                        </option>
                        <option value="first_transaction" {{ $settings['reward_criteria']->value == 'first_transaction' ? 'selected' : '' }}>
                            After First Transaction
                        </option>
                    </select>
                    <p class="text-xs text-gray-500 mt-2">
                        <i class="fas fa-info-circle mr-1"></i>When should rewards be given to referrer and referred user?
                    </p>
                </div>

                <!-- Reward Type -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-gift mr-2 text-purple-600"></i>Reward Type
                    </label>
                    <select name="reward_type" required class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-blue-500">
                        <option value="cash" {{ $settings['reward_type']->value == 'cash' ? 'selected' : '' }}>
                            Cash Reward
                        </option>
                        <option value="bonus" {{ $settings['reward_type']->value == 'bonus' ? 'selected' : '' }}>
                            Bonus Points
                        </option>
                        <option value="discount" {{ $settings['reward_type']->value == 'discount' ? 'selected' : '' }}>
                            Discount Coupon
                        </option>
                    </select>
                </div>

                <!-- Reward Amounts -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-user-tie mr-2 text-green-600"></i>Referrer Reward Amount (₹)
                        </label>
                        <input type="number" 
                               name="referrer_reward_amount" 
                               value="{{ $settings['referrer_reward_amount']->value }}" 
                               min="0" 
                               step="0.01" 
                               required 
                               class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-blue-500">
                        <p class="text-xs text-gray-500 mt-2">Amount given to the person who refers</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-user-plus mr-2 text-blue-600"></i>Referred User Reward Amount (₹)
                        </label>
                        <input type="number" 
                               name="referred_reward_amount" 
                               value="{{ $settings['referred_reward_amount']->value }}" 
                               min="0" 
                               step="0.01" 
                               required 
                               class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-blue-500">
                        <p class="text-xs text-gray-500 mt-2">Amount given to the new user</p>
                    </div>
                </div>

                <!-- Preview Card -->
                <div class="bg-blue-50/50 border border-blue-200 rounded-lg p-6">
                    <h4 class="text-sm font-semibold text-gray-700 mb-3">
                        <i class="fas fa-eye mr-2"></i>Reward Preview
                    </h4>
                    <div class="grid grid-cols-2 gap-4">
                        <div class="bg-white rounded-lg p-4 shadow-sm">
                            <p class="text-xs text-gray-500 mb-1">Referrer Gets</p>
                            <p class="text-2xl font-bold text-green-600">₹<span id="preview-referrer">{{ $settings['referrer_reward_amount']->value }}</span></p>
                        </div>
                        <div class="bg-white rounded-lg p-4 shadow-sm">
                            <p class="text-xs text-gray-500 mb-1">Referred User Gets</p>
                            <p class="text-2xl font-bold text-blue-600">₹<span id="preview-referred">{{ $settings['referred_reward_amount']->value }}</span></p>
                        </div>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="flex justify-end space-x-4 pt-6 border-t border-gray-200">
                    <a href="{{ route('admin.referrals.index') }}" class="px-6 py-3 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors">
                        Cancel
                    </a>
                    <button type="submit" class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                        <i class="fas fa-save mr-2"></i>Save Settings
                    </button>
                </div>
            </form>
        </div>

        <!-- Information Box -->
        <div class="mt-6 bg-blue-50 border border-blue-200 rounded-lg p-6">
            <h3 class="text-lg font-semibold text-blue-900 mb-3">
                <i class="fas fa-info-circle mr-2"></i>How Referral System Works
            </h3>
            <ul class="space-y-2 text-sm text-blue-800">
                <li class="flex items-start">
                    <i class="fas fa-check-circle mr-2 mt-1 text-blue-600"></i>
                    <span>Each user gets a unique referral code upon registration</span>
                </li>
                <li class="flex items-start">
                    <i class="fas fa-check-circle mr-2 mt-1 text-blue-600"></i>
                    <span>When a new user registers using a referral code, a referral record is created</span>
                </li>
                <li class="flex items-start">
                    <i class="fas fa-check-circle mr-2 mt-1 text-blue-600"></i>
                    <span>Rewards are processed based on the criteria you set (registration, KYC approval, or first transaction)</span>
                </li>
                <li class="flex items-start">
                    <i class="fas fa-check-circle mr-2 mt-1 text-blue-600"></i>
                    <span>Both referrer and referred user receive rewards as configured</span>
                </li>
                <li class="flex items-start">
                    <i class="fas fa-check-circle mr-2 mt-1 text-blue-600"></i>
                    <span>All referral activities are tracked and can be monitored from the admin panel</span>
                </li>
            </ul>
        </div>
    </div>

    <script>
        // Update preview when amounts change
        document.querySelector('input[name="referrer_reward_amount"]').addEventListener('input', function(e) {
            document.getElementById('preview-referrer').textContent = e.target.value || '0';
        });

        document.querySelector('input[name="referred_reward_amount"]').addEventListener('input', function(e) {
            document.getElementById('preview-referred').textContent = e.target.value || '0';
        });
    </script>
</x-app-layout>
