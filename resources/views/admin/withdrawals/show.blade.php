<x-app-layout>
    <div class="py-8 bg-gray-50 min-h-screen">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Header -->
            <div class="mb-6 flex items-center justify-between">
                <div>
                    <a href="{{ route('admin.withdrawals.index') }}" class="text-blue-600 hover:text-blue-800 mb-2 inline-block">
                        <i class="fas fa-arrow-left mr-2"></i>Back to Withdrawals List
                    </a>
                    <h1 class="text-3xl font-bold text-gray-900">Withdrawal Request Review</h1>
                </div>
                <span class="px-4 py-2 rounded-full text-sm font-medium
                    @if($withdrawal->status === 'pending') bg-yellow-100 text-yellow-800
                    @elseif($withdrawal->status === 'approved') bg-green-100 text-green-800
                    @else bg-red-100 text-red-800
                    @endif">
                    <i class="fas 
                        @if($withdrawal->status === 'pending') fa-clock
                        @elseif($withdrawal->status === 'approved') fa-check-circle
                        @else fa-times-circle
                        @endif mr-1"></i>
                    {{ ucfirst($withdrawal->status) }}
                </span>
            </div>

            @if(session('success'))
                <div class="mb-6 bg-green-50 border-l-4 border-green-400 p-4 rounded-lg shadow-sm">
                    <div class="flex">
                        <i class="fas fa-check-circle text-green-400 mt-1 mr-3"></i>
                        <p class="text-sm text-green-700 font-medium">{{ session('success') }}</p>
                    </div>
                </div>
            @endif

            @if(session('error'))
                <div class="mb-6 bg-red-50 border-l-4 border-red-400 p-4 rounded-lg shadow-sm">
                    <div class="flex">
                        <i class="fas fa-exclamation-circle text-red-400 mt-1 mr-3"></i>
                        <p class="text-sm text-red-700 font-medium">{{ session('error') }}</p>
                    </div>
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                
                <!-- Left Column - User Info -->
                <div class="lg:col-span-1 space-y-6">
                    
                    <!-- User Information -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                        <h2 class="text-lg font-bold text-gray-800 mb-4 border-b border-gray-50 pb-2">User Information</h2>
                        <div class="flex items-center mb-4">
                            <div class="h-14 w-14 rounded-full bg-red-500 flex items-center justify-center text-white text-xl font-bold shadow-md">
                                {{ $withdrawal->user->initials }}
                            </div>
                            <div class="ml-4">
                                <p class="font-bold text-gray-900">{{ $withdrawal->user->name }}</p>
                                <p class="text-xs text-gray-500">{{ $withdrawal->user->email }}</p>
                            </div>
                        </div>
                        <div class="space-y-3">
                            <div>
                                <p class="text-xs text-gray-400 font-semibold uppercase">Current Portfolio</p>
                                <p class="text-sm font-bold text-gray-800">${{ number_format($withdrawal->user->portfolio_value, 2) }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-400 font-semibold uppercase">User ID</p>
                                <p class="text-sm font-medium text-gray-700">#{{ $withdrawal->user->id }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-400 font-semibold uppercase">Phone Number</p>
                                <p class="text-sm font-medium text-gray-700">{{ $withdrawal->user->phone_number ?? 'N/A' }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Withdrawal Details -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                        <h2 class="text-lg font-bold text-gray-800 mb-4 border-b border-gray-50 pb-2">Withdrawal Details</h2>
                        <div class="space-y-3">
                            <div>
                                <p class="text-xs text-gray-400 font-semibold uppercase">Requested Payout Amount</p>
                                <p class="text-lg font-extrabold text-green-600">${{ number_format($withdrawal->amount, 2) }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-400 font-semibold uppercase">Processing Fee</p>
                                <p class="text-sm font-bold text-red-500">${{ number_format($withdrawal->fee, 2) }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-400 font-semibold uppercase">Total Locked/Deducted</p>
                                <p class="text-lg font-extrabold text-indigo-600">${{ number_format($withdrawal->amount + $withdrawal->fee, 2) }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-400 font-semibold uppercase">Payout Network</p>
                                <p class="text-sm font-bold text-gray-800">
                                    <span class="px-2 py-0.5 rounded-full text-xs font-semibold {{ $withdrawal->network === 'BEP20' ? 'bg-blue-50 text-blue-700 border border-blue-100' : 'bg-red-50 text-red-700 border border-red-100' }}">
                                        {{ $withdrawal->network }}
                                    </span>
                                </p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-400 font-semibold uppercase">Submitted On</p>
                                <p class="text-sm font-medium text-gray-700">{{ $withdrawal->created_at->format('d M Y, h:i A') }}</p>
                            </div>
                            @if($withdrawal->status !== 'pending')
                                <div>
                                    <p class="text-xs text-gray-400 font-semibold uppercase">Processed On</p>
                                    <p class="text-sm font-medium text-gray-700">
                                        {{ $withdrawal->approved_at ? $withdrawal->approved_at->format('d M Y, h:i A') : ($withdrawal->rejected_at ? $withdrawal->rejected_at->format('d M Y, h:i A') : 'N/A') }}
                                    </p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Right Column - Target Wallet and Review Actions -->
                <div class="lg:col-span-2 space-y-6">
                    
                    <!-- Target Address -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                        <h2 class="text-lg font-bold text-gray-800 mb-4 border-b border-gray-50 pb-2">Target Wallet Address</h2>
                        
                        <div class="p-4 bg-gray-50 rounded-xl border border-gray-150 flex items-center justify-between shadow-inner">
                            <code class="text-base text-gray-800 font-mono select-all overflow-hidden text-ellipsis mr-4 font-bold" id="targetAddr">{{ $withdrawal->wallet_address }}</code>
                            <button type="button" onclick="navigator.clipboard.writeText('{{ $withdrawal->wallet_address }}'); alert('Address copied to clipboard!')" class="px-3 py-2 bg-white hover:bg-gray-100 border rounded-lg text-blue-600 font-semibold text-xs flex items-center shadow-sm whitespace-nowrap transition-colors">
                                <i class="far fa-copy mr-1.5"></i> Copy Address
                            </button>
                        </div>
                        <p class="text-xs text-gray-400 mt-2 flex items-center"><i class="fas fa-exclamation-triangle text-amber-500 mr-1"></i> Make sure you send funds on the correct network: <span class="font-bold text-gray-700 ml-1">{{ $withdrawal->network }}</span></p>
                    </div>

                    <!-- Process Remarks & TXID display if already processed -->
                    @if($withdrawal->status !== 'pending')
                        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 space-y-4">
                            @if($withdrawal->transaction_id)
                                <div>
                                    <p class="text-xs text-gray-400 font-semibold uppercase mb-1">Payout Transaction ID (TXID)</p>
                                    <code class="text-sm font-mono text-gray-800 select-all font-semibold bg-gray-50 p-2 rounded border block break-all shadow-inner">{{ $withdrawal->transaction_id }}</code>
                                </div>
                            @endif
                            
                            @if($withdrawal->remarks)
                                <div>
                                    <p class="text-xs text-gray-400 font-semibold uppercase mb-1">Remarks</p>
                                    <p class="text-gray-700 text-sm font-medium bg-gray-50 p-3 rounded border">{{ $withdrawal->remarks }}</p>
                                </div>
                            @endif
                        </div>
                    @endif

                    <!-- Review Actions -->
                    @if($withdrawal->status === 'pending')
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                        <h2 class="text-lg font-bold text-gray-800 mb-4 border-b border-gray-50 pb-2">Review Actions</h2>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Approve Form -->
                            <form action="{{ route('admin.withdrawals.approve', $withdrawal->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to approve this withdrawal request? Confirm that you have manually transferred ${{ $withdrawal->amount }} to the user\'s wallet address.')" class="space-y-4">
                                @csrf
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">Payout Transaction ID / TXID (Optional)</label>
                                    <input type="text" name="transaction_id" 
                                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent text-sm font-mono"
                                           placeholder="Enter blockchain hash/TXID...">
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">Approval Remarks (Optional)</label>
                                    <textarea name="remarks" rows="2" 
                                              class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent text-sm"
                                              placeholder="Enter approval details..."></textarea>
                                </div>
                                <button type="submit" 
                                        class="w-full px-4 py-3 bg-green-600 hover:bg-green-700 text-white font-bold rounded-xl shadow transition-colors flex items-center justify-center">
                                    <i class="fas fa-check-circle mr-2"></i> Approve & Mark Paid
                                </button>
                            </form>

                            <!-- Reject Form -->
                            <form action="{{ route('admin.withdrawals.reject', $withdrawal->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to reject this withdrawal request? This will refund ${{ $withdrawal->amount + $withdrawal->fee }} back to the user\'s active portfolio.')" class="space-y-4">
                                @csrf
                                <div class="h-[60px] flex items-end">
                                    <!-- Empty space to align with Approve Form's TXID field -->
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">Rejection Remarks / Reason <span class="text-red-500">*</span></label>
                                    <textarea name="remarks" rows="2" required
                                              class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent text-sm"
                                              placeholder="Explain the reason for rejecting the withdrawal (e.g. invalid address)..."></textarea>
                                </div>
                                <button type="submit" 
                                        class="w-full px-4 py-3 bg-red-600 hover:bg-red-700 text-white font-bold rounded-xl shadow transition-colors flex items-center justify-center">
                                    <i class="fas fa-times-circle mr-2"></i> Reject & Refund Funds
                                </button>
                            </form>
                        </div>
                    </div>
                    @endif
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
