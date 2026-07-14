<x-app-layout>
    <div class="py-8 bg-gray-50 min-h-screen">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Header -->
            <div class="mb-6 flex items-center justify-between">
                <div>
                    <a href="{{ route('admin.deposits.index') }}" class="text-blue-600 hover:text-blue-800 mb-2 inline-block">
                        <i class="fas fa-arrow-left mr-2"></i>Back to Deposits List
                    </a>
                    <h1 class="text-3xl font-bold text-gray-900">Deposit Request Review</h1>
                </div>
                <span class="px-4 py-2 rounded-full text-sm font-medium
                    @if($deposit->status === 'pending') bg-yellow-100 text-yellow-800
                    @elseif($deposit->status === 'approved') bg-green-100 text-green-800
                    @else bg-red-100 text-red-800
                    @endif">
                    <i class="fas 
                        @if($deposit->status === 'pending') fa-clock
                        @elseif($deposit->status === 'approved') fa-check-circle
                        @else fa-times-circle
                        @endif mr-1"></i>
                    {{ ucfirst($deposit->status) }}
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
                
                <!-- Left Column - User & Request Info -->
                <div class="lg:col-span-1 space-y-6">
                    
                    <!-- User Information -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                        <h2 class="text-lg font-bold text-gray-800 mb-4 border-b border-gray-50 pb-2">User Information</h2>
                        <div class="flex items-center mb-4">
                            <div class="h-14 w-14 rounded-full bg-blue-500 flex items-center justify-center text-white text-xl font-bold shadow-md">
                                {{ $deposit->user->initials }}
                            </div>
                            <div class="ml-4">
                                <p class="font-bold text-gray-900">{{ $deposit->user->name }}</p>
                                <p class="text-xs text-gray-500">{{ $deposit->user->email }}</p>
                            </div>
                        </div>
                        <div class="space-y-3">
                            <div>
                                <p class="text-xs text-gray-400 font-semibold uppercase">Current Portfolio</p>
                                <p class="text-sm font-bold text-gray-800">${{ number_format($deposit->user->portfolio_value, 2) }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-400 font-semibold uppercase">User ID</p>
                                <p class="text-sm font-medium text-gray-700">#{{ $deposit->user->id }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-400 font-semibold uppercase">Phone Number</p>
                                <p class="text-sm font-medium text-gray-700">{{ $deposit->user->phone_number ?? 'N/A' }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Deposit Details -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                        <h2 class="text-lg font-bold text-gray-800 mb-4 border-b border-gray-50 pb-2">Deposit Details</h2>
                        <div class="space-y-3">
                            <div>
                                <p class="text-xs text-gray-400 font-semibold uppercase">Requested Amount</p>
                                <p class="text-lg font-extrabold text-blue-600">${{ number_format($deposit->amount, 2) }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-400 font-semibold uppercase">Transfer Network</p>
                                <p class="text-sm font-bold text-gray-800">
                                    <span class="px-2 py-0.5 rounded-full text-xs font-semibold {{ $deposit->network === 'BEP20' ? 'bg-blue-50 text-blue-700 border border-blue-100' : 'bg-red-50 text-red-700 border border-red-100' }}">
                                        {{ $deposit->network }}
                                    </span>
                                </p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-400 font-semibold uppercase">Transaction ID / TXID</p>
                                <p class="text-sm font-mono text-gray-700 break-all select-all font-semibold">{{ $deposit->transaction_id }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-400 font-semibold uppercase">Submitted On</p>
                                <p class="text-sm font-medium text-gray-700">{{ $deposit->created_at->format('d M Y, h:i A') }}</p>
                            </div>
                            @if($deposit->status !== 'pending')
                                <div>
                                    <p class="text-xs text-gray-400 font-semibold uppercase">Processed On</p>
                                    <p class="text-sm font-medium text-gray-700">
                                        {{ $deposit->approved_at ? $deposit->approved_at->format('d M Y, h:i A') : ($deposit->rejected_at ? $deposit->rejected_at->format('d M Y, h:i A') : 'N/A') }}
                                    </p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Right Column - Screenshot and Action Buttons -->
                <div class="lg:col-span-2 space-y-6">
                    
                    <!-- Proof Screenshot -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                        <h2 class="text-lg font-bold text-gray-800 mb-4 border-b border-gray-50 pb-2">Uploaded Proof Receipt</h2>
                        <div class="border rounded-xl overflow-hidden bg-gray-50 flex justify-center p-2 shadow-inner">
                            <img src="{{ asset('storage/' . $deposit->screenshot_path) }}" 
                                 alt="Payment Proof Receipt" 
                                 class="max-w-full h-auto max-h-[500px] object-contain rounded-lg cursor-pointer hover:opacity-90 transition-opacity"
                                 onclick="openImageModal(this.src)">
                        </div>
                        <p class="text-center text-xs text-gray-400 mt-2"><i class="fas fa-search-plus mr-1"></i> Click on the image to view full screen</p>
                    </div>

                    <!-- Remarks display if already processed -->
                    @if($deposit->status !== 'pending' && $deposit->remarks)
                        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                            <h2 class="text-lg font-bold text-gray-800 mb-2">Process Remarks</h2>
                            <p class="text-gray-700 text-sm font-medium">{{ $deposit->remarks }}</p>
                        </div>
                    @endif

                    <!-- Review Actions -->
                    @if($deposit->status === 'pending')
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                        <h2 class="text-lg font-bold text-gray-800 mb-4 border-b border-gray-50 pb-2">Review Actions</h2>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Approve Form -->
                            <form action="{{ route('admin.deposits.approve', $deposit->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to approve this deposit? This will credit ${{ $deposit->amount }} directly to the user\'s active portfolio.')" class="space-y-4">
                                @csrf
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">Approval Remarks (Optional)</label>
                                    <textarea name="remarks" rows="3" 
                                              class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent text-sm"
                                              placeholder="Enter approval details or block height..."></textarea>
                                </div>
                                <button type="submit" 
                                        class="w-full px-4 py-3 bg-green-600 hover:bg-green-700 text-white font-bold rounded-xl shadow transition-colors flex items-center justify-center">
                                    <i class="fas fa-check-circle mr-2"></i> Approve & Credit Funds
                                </button>
                            </form>

                            <!-- Reject Form -->
                            <form action="{{ route('admin.deposits.reject', $deposit->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to reject this deposit request?')" class="space-y-4">
                                @csrf
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">Rejection Remarks / Reason <span class="text-red-500">*</span></label>
                                    <textarea name="remarks" rows="3" required
                                              class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent text-sm"
                                              placeholder="Explain the reason for rejecting the receipt..."></textarea>
                                </div>
                                <button type="submit" 
                                        class="w-full px-4 py-3 bg-red-600 hover:bg-red-700 text-white font-bold rounded-xl shadow transition-colors flex items-center justify-center">
                                    <i class="fas fa-times-circle mr-2"></i> Reject Request
                                </button>
                            </form>
                        </div>
                    </div>
                    @endif
                </div>

            </div>
        </div>
    </div>

    <!-- Image Modal -->
    <div id="imageModal" class="hidden fixed inset-0 bg-black bg-opacity-75 z-50 flex items-center justify-center p-4" onclick="closeImageModal()">
        <div class="relative max-w-5xl w-full">
            <button onclick="closeImageModal()" class="absolute top-4 right-4 text-white text-3xl hover:text-gray-300 focus:outline-none">
                <i class="fas fa-times"></i>
            </button>
            <img id="modalImage" src="" alt="Document" class="w-full h-auto rounded-lg max-h-[90vh] object-contain shadow-2xl">
        </div>
    </div>

    <script>
        function openImageModal(src) {
            document.getElementById('imageModal').classList.remove('hidden');
            document.getElementById('modalImage').src = src;
        }

        function closeImageModal() {
            document.getElementById('imageModal').classList.add('hidden');
        }
    </script>
</x-app-layout>
