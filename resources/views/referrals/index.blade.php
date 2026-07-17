<x-app-layout>
    <div class="py-8 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Page Title -->
            <div class="mb-6">
                <h1 class="text-3xl font-bold text-gray-900">Referral Program</h1>
                <p class="text-gray-600 mt-2">Invite friends and earn rewards together!</p>
            </div>
        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <div class="bg-white rounded-lg shadow-md p-6 card-hover">
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

            <div class="bg-white rounded-lg shadow-md p-6 card-hover">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm font-medium">Active Referrals</p>
                        <p class="text-3xl font-bold text-green-600 mt-2">{{ $stats['active_referrals'] }}</p>
                    </div>
                    <div class="bg-green-100 rounded-full p-4">
                        <i class="fas fa-user-check text-green-600 text-2xl"></i>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-md p-6 card-hover">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm font-medium">Pending Referrals</p>
                        <p class="text-3xl font-bold text-yellow-600 mt-2">{{ $stats['pending_referrals'] }}</p>
                    </div>
                    <div class="bg-yellow-100 rounded-full p-4">
                        <i class="fas fa-clock text-yellow-600 text-2xl"></i>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-md p-6 card-hover">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm font-medium">Total Earnings</p>
                        <p class="text-3xl font-bold text-purple-600 mt-2">${{ number_format($stats['total_earnings'], 2) }}</p>
                    </div>
                    <div class="bg-purple-100 rounded-full p-4">
                        <i class="fas fa-coins text-purple-600 text-2xl"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Referral Link Card -->
        <div class="bg-indigo-600 rounded-lg shadow-lg p-8 mb-8 text-white">
            <h2 class="text-2xl font-bold mb-4">Share Your Referral Link</h2>
            <p class="mb-6 opacity-90">Invite your friends and earn rewards when they complete their KYC!</p>
            
            <div class="bg-white bg-opacity-20 rounded-lg p-4 mb-4">
                <div class="flex items-center justify-between">
                    <div class="flex-1">
                        <p class="text-sm opacity-75 mb-1">Your Referral Code</p>
                        <p class="text-2xl font-bold" id="referralCode">{{ $stats['referral_code'] }}</p>
                    </div>
                    <button onclick="copyCode()" class="bg-white text-blue-600 px-4 py-2 rounded-lg hover:bg-opacity-90 transition-colors">
                        <i class="fas fa-copy mr-2"></i>Copy Code
                    </button>
                </div>
            </div>

            <div class="bg-white bg-opacity-20 rounded-lg p-4 mb-6">
                <div class="flex items-center justify-between">
                    <div class="flex-1">
                        <p class="text-sm opacity-75 mb-1">Your Referral Link</p>
                        <p class="text-sm break-all" id="referralLink">{{ $stats['referral_link'] }}</p>
                    </div>
                    <button onclick="copyLink()" class="bg-white text-blue-600 px-4 py-2 rounded-lg hover:bg-opacity-90 transition-colors ml-4">
                        <i class="fas fa-link mr-2"></i>Copy Link
                    </button>
                </div>
            </div>

            <!-- Social Share Buttons -->
            <div class="flex flex-wrap gap-3">
                <button onclick="shareWhatsApp()" class="bg-green-500 hover:bg-green-600 px-6 py-3 rounded-lg transition-colors">
                    <i class="fab fa-whatsapp mr-2"></i>Share on WhatsApp
                </button>
                <button onclick="shareTwitter()" class="bg-blue-400 hover:bg-blue-500 px-6 py-3 rounded-lg transition-colors">
                    <i class="fab fa-twitter mr-2"></i>Share on Twitter
                </button>
                <button onclick="shareFacebook()" class="bg-blue-700 hover:bg-blue-800 px-6 py-3 rounded-lg transition-colors">
                    <i class="fab fa-facebook mr-2"></i>Share on Facebook
                </button>
                <button onclick="shareEmail()" class="bg-gray-700 hover:bg-gray-800 px-6 py-3 rounded-lg transition-colors">
                    <i class="fas fa-envelope mr-2"></i>Share via Email
                </button>
            </div>
        </div>

        <!-- Tabs -->
        <div class="bg-white rounded-lg shadow-md mb-8">
            <div class="border-b border-gray-200">
                <nav class="flex -mb-px">
                    <button onclick="showTab('referrals')" id="referralsTab" class="tab-button active px-6 py-4 text-sm font-medium border-b-2 border-blue-600 text-blue-600">
                        <i class="fas fa-users mr-2"></i>My Referrals
                    </button>
                    <button onclick="showTab('rewards')" id="rewardsTab" class="tab-button px-6 py-4 text-sm font-medium border-b-2 border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300">
                        <i class="fas fa-gift mr-2"></i>Rewards History
                    </button>
                </nav>
            </div>

            <!-- Referrals Tab Content -->
            <div id="referralsContent" class="tab-content p-6">
                @if($referrals->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Joined Date</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Reward Status</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($referrals as $referral)
                                <tr>
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
                                                <i class="fas fa-clock mr-1"></i>Pending
                                            </span>
                                        @elseif($referral->status === 'active')
                                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                <i class="fas fa-check-circle mr-1"></i>Active
                                            </span>
                                        @else
                                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                                <i class="fas fa-trophy mr-1"></i>Rewarded
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        @if($referral->rewards->count() > 0)
                                            @php $reward = $referral->rewards->where('user_id', auth()->id())->first(); @endphp
                                            @if($reward)
                                                @if($reward->status === 'credited')
                                                    <span class="text-green-600 font-medium">
                                                        <i class="fas fa-check-circle mr-1"></i>${{ number_format($reward->reward_amount, 2) }} Credited
                                                    </span>
                                                @else
                                                    <span class="text-yellow-600 font-medium">
                                                        <i class="fas fa-hourglass-half mr-1"></i>${{ number_format($reward->reward_amount, 2) }} Pending
                                                    </span>
                                                @endif
                                            @else
                                                <span class="text-gray-400">No reward yet</span>
                                            @endif
                                        @else
                                            <span class="text-gray-400">No reward yet</span>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-4">
                        {{ $referrals->links() }}
                    </div>
                @else
                    <div class="text-center py-12">
                        <i class="fas fa-users text-gray-300 text-6xl mb-4"></i>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">No referrals yet</h3>
                        <p class="text-gray-500">Start sharing your referral link to earn rewards!</p>
                    </div>
                @endif
            </div>

            <!-- Rewards Tab Content -->
            <div id="rewardsContent" class="tab-content p-6 hidden">
                @if($rewards->count() > 0)
                    <div class="space-y-4">
                        @foreach($rewards as $reward)
                        <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition-shadow">
                            <div class="flex items-center justify-between">
                                <div class="flex-1">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0">
                                            @if($reward->status === 'credited')
                                                <div class="bg-green-100 rounded-full p-3">
                                                    <i class="fas fa-check-circle text-green-600 text-xl"></i>
                                                </div>
                                            @elseif($reward->status === 'pending')
                                                <div class="bg-yellow-100 rounded-full p-3">
                                                    <i class="fas fa-clock text-yellow-600 text-xl"></i>
                                                </div>
                                            @else
                                                <div class="bg-red-100 rounded-full p-3">
                                                    <i class="fas fa-times-circle text-red-600 text-xl"></i>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="ml-4">
                                            <h4 class="text-sm font-medium text-gray-900">{{ $reward->reward_description }}</h4>
                                            <p class="text-sm text-gray-500">
                                                @if($reward->referral && $reward->referral->referredUser)
                                                    For referring {{ $reward->referral->referredUser->name }}
                                                @endif
                                            </p>
                                            <p class="text-xs text-gray-400 mt-1">
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
                    <div class="mt-4">
                        {{ $rewards->links() }}
                    </div>
                @else
                    <div class="text-center py-12">
                        <i class="fas fa-gift text-gray-300 text-6xl mb-4"></i>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">No rewards yet</h3>
                        <p class="text-gray-500">Your rewards will appear here once your referrals complete their KYC.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <style>
        .card-hover {
            transition: all 0.3s ease;
        }
        .card-hover:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        }
    </style>

    <script>
        function showTab(tab) {
            // Hide all tab contents
            document.querySelectorAll('.tab-content').forEach(content => {
                content.classList.add('hidden');
            });
            
            // Remove active class from all tabs
            document.querySelectorAll('.tab-button').forEach(button => {
                button.classList.remove('active', 'border-blue-600', 'text-blue-600');
                button.classList.add('border-transparent', 'text-gray-500');
            });
            
            // Show selected tab content
            document.getElementById(tab + 'Content').classList.remove('hidden');
            
            // Add active class to selected tab
            const activeTab = document.getElementById(tab + 'Tab');
            activeTab.classList.add('active', 'border-blue-600', 'text-blue-600');
            activeTab.classList.remove('border-transparent', 'text-gray-500');
        }

        function copyCode() {
            const code = document.getElementById('referralCode').textContent;
            navigator.clipboard.writeText(code).then(() => {
                showNotification('Referral code copied to clipboard!');
            });
        }

        function copyLink() {
            const link = document.getElementById('referralLink').textContent;
            navigator.clipboard.writeText(link).then(() => {
                showNotification('Referral link copied to clipboard!');
            });
        }

        function shareWhatsApp() {
            const link = document.getElementById('referralLink').textContent;
            const text = `Join Finovo using my referral link and start your investment journey! ${link}`;
            window.open(`https://wa.me/?text=${encodeURIComponent(text)}`, '_blank');
        }

        function shareTwitter() {
            const link = document.getElementById('referralLink').textContent;
            const text = `Join Finovo using my referral link and start your investment journey!`;
            window.open(`https://twitter.com/intent/tweet?text=${encodeURIComponent(text)}&url=${encodeURIComponent(link)}`, '_blank');
        }

        function shareFacebook() {
            const link = document.getElementById('referralLink').textContent;
            window.open(`https://www.facebook.com/sharer/sharer.php?u=${encodeURIComponent(link)}`, '_blank');
        }

        function shareEmail() {
            const link = document.getElementById('referralLink').textContent;
            const subject = 'Join Finovo - Investment Platform';
            const body = `Hi,\\n\\nI'd like to invite you to join Finovo, an amazing investment platform.\\n\\nUse my referral link to get started: ${link}\\n\\nLooking forward to seeing you there!`;
            window.location.href = `mailto:?subject=${encodeURIComponent(subject)}&body=${encodeURIComponent(body)}`;
        }

        function showNotification(message) {
            // Create notification element
            const notification = document.createElement('div');
            notification.className = 'fixed top-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg z-50 animate-fade-in';
            notification.innerHTML = `<i class="fas fa-check-circle mr-2"></i>${message}`;
            document.body.appendChild(notification);
            
            // Remove after 3 seconds
            setTimeout(() => {
                notification.remove();
            }, 3000);
        }
    </script>
</x-app-layout>
