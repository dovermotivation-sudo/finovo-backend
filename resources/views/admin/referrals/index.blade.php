<x-app-layout>
    <div class="py-8 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Page Header -->
            <div class="mb-6 flex justify-between items-center">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Referral Management</h1>
                    <p class="text-gray-600 mt-2">Manage and monitor all referral activities</p>
                </div>
                <a href="{{ route('admin.referrals.settings') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors">
                    <i class="fas fa-cog mr-2"></i>Settings
                </a>
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

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm font-medium">Total Referrals</p>
                        <p class="text-3xl font-bold text-gray-800 mt-2">{{ $stats['total_referrals'] }}</p>
                    </div>
                    <div class="bg-blue-100 rounded-full p-4">
                        <i class="fas fa-users text-blue-600 text-2xl"></i>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm font-medium">Pending</p>
                        <p class="text-3xl font-bold text-yellow-600 mt-2">{{ $stats['pending_referrals'] }}</p>
                    </div>
                    <div class="bg-yellow-100 rounded-full p-4">
                        <i class="fas fa-clock text-yellow-600 text-2xl"></i>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm font-medium">Active</p>
                        <p class="text-3xl font-bold text-green-600 mt-2">{{ $stats['active_referrals'] }}</p>
                    </div>
                    <div class="bg-green-100 rounded-full p-4">
                        <i class="fas fa-check-circle text-green-600 text-2xl"></i>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm font-medium">Total Rewards</p>
                        <p class="text-3xl font-bold text-purple-600 mt-2">₹{{ number_format($stats['total_rewards_given'], 2) }}</p>
                    </div>
                    <div class="bg-purple-100 rounded-full p-4">
                        <i class="fas fa-gift text-purple-600 text-2xl"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filters -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-8">
            <form method="GET" action="{{ route('admin.referrals.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                    <select name="status" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500">
                        <option value="">All Status</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="rewarded" {{ request('status') == 'rewarded' ? 'selected' : '' }}>Rewarded</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">From Date</label>
                    <input type="date" name="date_from" value="{{ request('date_from') }}" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">To Date</label>
                    <input type="date" name="date_to" value="{{ request('date_to') }}" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500">
                </div>

                <div class="flex items-end">
                    <button type="submit" class="w-full bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition-colors">
                        <i class="fas fa-filter mr-2"></i>Apply Filters
                    </button>
                </div>
            </form>
        </div>

        <!-- Referrals Table -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <form id="deleteForm" action="{{ route('admin.referrals.delete') }}" method="POST">
                @csrf
                @method('DELETE')
                
                <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                    <h2 class="text-xl font-semibold text-gray-800">All Referrals</h2>
                    <div class="flex items-center space-x-4">
                        <input type="checkbox" id="selectAll" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500">
                        <label for="selectAll" class="text-sm font-medium text-gray-700">Select All</label>
                        <button type="button" id="deleteBtn" class="px-4 py-2 bg-red-600 text-white text-sm font-medium rounded-lg shadow hover:bg-red-700 transition-colors disabled:bg-gray-400 disabled:cursor-not-allowed" disabled>
                            Delete Selected
                        </button>
                    </div>
                </div>

            @if($referrals->count() > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Select</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Referrer</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Referred User</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Rewards</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($referrals as $referral)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <input type="checkbox" name="referrals[]" value="{{ $referral->id }}" class="referral-checkbox w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500">
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    #{{ $referral->id }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10">
                                            <img class="h-10 w-10 rounded-full" src="{{ $referral->referrer->profile_image_url ?? 'https://ui-avatars.com/api/?name=' . urlencode($referral->referrer->name) }}" alt="">
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">{{ $referral->referrer->name }}</div>
                                            <div class="text-sm text-gray-500">{{ $referral->referrer->email }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10">
                                            <img class="h-10 w-10 rounded-full" src="{{ $referral->referredUser->profile_image_url ?? 'https://ui-avatars.com/api/?name=' . urlencode($referral->referredUser->name) }}" alt="">
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">{{ $referral->referredUser->name }}</div>
                                            <div class="text-sm text-gray-500">{{ $referral->referredUser->email }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $referral->referred_at->format('M d, Y') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($referral->status === 'pending')
                                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                            Pending
                                        </span>
                                    @elseif($referral->status === 'active')
                                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                            Active
                                        </span>
                                    @else
                                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                            Rewarded
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    @if($referral->rewards->count() > 0)
                                        <span class="text-green-600 font-medium">
                                            ₹{{ number_format($referral->rewards->sum('reward_amount'), 2) }}
                                        </span>
                                    @else
                                        <span class="text-gray-400">No rewards</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <a href="{{ route('admin.referrals.show', $referral->id) }}" class="text-blue-600 hover:text-blue-900 mr-3">
                                        <i class="fas fa-eye"></i> View
                                    </a>
                                    @if($referral->status !== 'rewarded')
                                        <form action="{{ route('admin.referrals.process-reward', $referral->id) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit" class="text-green-600 hover:text-green-900" onclick="return confirm('Process reward for this referral?')">
                                                <i class="fas fa-gift"></i> Reward
                                            </button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="px-6 py-4 border-t border-gray-200">
                    {{ $referrals->links() }}
                </div>
            @else
                <div class="text-center py-12">
                    <i class="fas fa-users text-gray-300 text-6xl mb-4"></i>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">No referrals found</h3>
                    <p class="text-gray-500">Referrals will appear here when users start referring others.</p>
                </div>
            @endif
            </form>
        </div>
    </div>
</x-app-layout>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const selectAllCheckbox = document.getElementById('selectAll');
    const referralCheckboxes = document.querySelectorAll('.referral-checkbox');
    const deleteBtn = document.getElementById('deleteBtn');
    const deleteForm = document.getElementById('deleteForm');

    function updateDeleteButton() {
        const checkedBoxes = document.querySelectorAll('.referral-checkbox:checked');
        deleteBtn.disabled = checkedBoxes.length === 0;
    }

    selectAllCheckbox.addEventListener('change', function() {
        referralCheckboxes.forEach(checkbox => {
            checkbox.checked = this.checked;
        });
        updateDeleteButton();
    });

    referralCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            const allChecked = Array.from(referralCheckboxes).every(cb => cb.checked);
            const someChecked = Array.from(referralCheckboxes).some(cb => cb.checked);
            
            selectAllCheckbox.checked = allChecked;
            selectAllCheckbox.indeterminate = someChecked && !allChecked;
            
            updateDeleteButton();
        });
    });

    deleteBtn.addEventListener('click', function() {
        const checkedBoxes = document.querySelectorAll('.referral-checkbox:checked');
        const count = checkedBoxes.length;
        
        if (count === 0) {
            return;
        }

        if (confirm(`Are you sure you want to delete ${count} referral(s)? This action cannot be undone and will permanently remove all associated rewards.`)) {
            deleteForm.submit();
        }
    });
});
</script>
