<x-app-layout>
    <div class="py-8 bg-gray-50 min-h-screen">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Success/Error Messages -->
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

            <!-- Header -->
            <div class="text-center mb-8">
                <div class="inline-flex items-center justify-center w-16 h-16 bg-red-100 rounded-full mb-4 shadow-inner">
                    <i class="fas fa-hand-holding-usd text-3xl text-red-600"></i>
                </div>
                <h1 class="text-3xl font-bold text-gray-900 mb-2">Withdraw Funds</h1>
                <p class="text-gray-600">Request a withdrawal from your active portfolio value to your crypto wallet address</p>
            </div>

            <!-- Single Grid containing Balance & Form -->
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 mb-8" x-data="{ 
                network: 'BEP20', 
                amount: '{{ old('amount') }}',
                portfolioValue: {{ Auth::user()->portfolio_value }},
                fee: 1.00
            }">
                
                <!-- Left Column - Balance Info & Network Information -->
                <div class="lg:col-span-5 bg-white rounded-2xl shadow-md p-6 border border-gray-100 flex flex-col justify-between">
                    <div>
                        <h2 class="text-xl font-bold text-gray-800 mb-4 flex items-center">
                            <span class="w-8 h-8 bg-red-100 rounded-lg text-red-600 flex items-center justify-center text-sm font-bold mr-2">1</span>
                            Portfolio Balance
                        </h2>

                        <!-- Portfolio Balance Display -->
                        <div class="bg-gradient-to-r from-red-50 to-orange-50 rounded-2xl p-6 border border-red-100/50 text-center mb-6">
                            <p class="text-xs text-red-500 font-bold uppercase tracking-wider mb-1">Available for Withdrawal</p>
                            <h3 class="text-4xl font-extrabold text-gray-900 mb-2">
                                ${{ number_format(Auth::user()->portfolio_value, 2) }}
                            </h3>
                            <p class="text-xs text-gray-500">Your requested withdrawal amount will be locked immediately and refunded if rejected.</p>
                        </div>

                        <!-- Network Guidelines -->
                        <div class="space-y-4">
                            <h4 class="text-sm font-semibold text-gray-700">Supported Networks & Fees</h4>
                            
                            <div class="p-3 bg-gray-50 rounded-xl border border-gray-100 flex items-center justify-between">
                                <div class="flex items-center space-x-3">
                                    <div class="w-9 h-9 bg-blue-100 rounded-lg text-blue-600 flex items-center justify-center font-bold text-xs">BSC</div>
                                    <div>
                                        <p class="text-sm font-bold text-gray-800">BEP20 (Binance Smart Chain)</p>
                                        <p class="text-xs text-gray-500">Low network fees • Fast processing</p>
                                    </div>
                                </div>
                            </div>

                            <div class="p-3 bg-gray-50 rounded-xl border border-gray-100 flex items-center justify-between">
                                <div class="flex items-center space-x-3">
                                    <div class="w-9 h-9 bg-red-100 rounded-lg text-red-600 flex items-center justify-center font-bold text-xs">TRX</div>
                                    <div>
                                        <p class="text-sm font-bold text-gray-800">TRC20 (Tron Network)</p>
                                        <p class="text-xs text-gray-500">Standard fees • Ultra fast processing</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column - Submit Withdrawal Request -->
                <div class="lg:col-span-7 bg-white rounded-2xl shadow-md p-6 border border-gray-100">
                    <h2 class="text-xl font-bold text-gray-800 mb-4 flex items-center">
                        <span class="w-8 h-8 bg-red-100 rounded-lg text-red-600 flex items-center justify-center text-sm font-bold mr-2">2</span>
                        Withdrawal Details
                    </h2>

                    <form action="{{ route('withdrawals.store') }}" method="POST" class="space-y-4">
                        @csrf
                        
                        <!-- Bind selected network to hidden input -->
                        <input type="hidden" name="network" :value="network">

                        <!-- Network Selector -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Select Payout Network <span class="text-red-500">*</span></label>
                            <div class="grid grid-cols-2 gap-4">
                                <button type="button" @click="network = 'BEP20'" 
                                    :class="network === 'BEP20' ? 'border-red-500 bg-red-50 text-red-700 ring-2 ring-red-500/20' : 'border-gray-200 bg-white text-gray-700 hover:bg-gray-50'"
                                    class="py-3 px-4 rounded-xl border font-bold text-center transition-all duration-200">
                                    <i class="fab fa-ethereum mr-2"></i>BEP20 (BSC)
                                </button>
                                <button type="button" @click="network = 'TRC20'" 
                                    :class="network === 'TRC20' ? 'border-red-500 bg-red-50 text-red-700 ring-2 ring-red-500/20' : 'border-gray-200 bg-white text-gray-700 hover:bg-gray-50'"
                                    class="py-3 px-4 rounded-xl border font-bold text-center transition-all duration-200">
                                    <i class="fas fa-bolt mr-2"></i>TRC20 (TRON)
                                </button>
                            </div>
                        </div>

                        <!-- Input Wallet Address -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Destination Wallet Address <span class="text-red-500">*</span></label>
                            <input type="text" name="wallet_address" required 
                                   class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-red-500 focus:border-transparent transition-all font-mono text-sm" 
                                   placeholder="Enter your BEP20 or TRC20 wallet address" value="{{ old('wallet_address') }}">
                            @error('wallet_address')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            <p class="mt-1 text-xs text-gray-400">Double check your address. Transactions cannot be reversed if sent to an incorrect address.</p>
                        </div>

                        <!-- Input Amount -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Amount to Withdraw (USD) <span class="text-red-500">*</span></label>
                            <div class="relative rounded-xl shadow-sm">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <span class="text-gray-500 sm:text-sm">$</span>
                                </div>
                                <input type="number" name="amount" step="0.01" required x-model="amount"
                                       class="w-full pl-8 pr-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-red-500 focus:border-transparent transition-all" 
                                       placeholder="0.00" max="{{ Auth::user()->portfolio_value }}">
                            </div>
                            @error('amount')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            
                            <!-- Quick amount choices -->
                            <div class="flex space-x-2 mt-2">
                                <button type="button" @click="amount = (portfolioValue >= fee ? (portfolioValue - fee) * 0.25 : 0).toFixed(2)" class="px-3 py-1 bg-gray-100 hover:bg-gray-200 text-xs font-semibold text-gray-600 rounded-lg transition-colors">25%</button>
                                <button type="button" @click="amount = (portfolioValue >= fee ? (portfolioValue - fee) * 0.50 : 0).toFixed(2)" class="px-3 py-1 bg-gray-100 hover:bg-gray-200 text-xs font-semibold text-gray-600 rounded-lg transition-colors">50%</button>
                                <button type="button" @click="amount = (portfolioValue >= fee ? (portfolioValue - fee) * 0.75 : 0).toFixed(2)" class="px-3 py-1 bg-gray-100 hover:bg-gray-200 text-xs font-semibold text-gray-600 rounded-lg transition-colors">75%</button>
                                <button type="button" @click="amount = (portfolioValue >= fee ? (portfolioValue - fee) : 0).toFixed(2)" class="px-3 py-1 bg-gray-100 hover:bg-gray-200 text-xs font-semibold text-gray-600 rounded-lg transition-colors">100% (Max)</button>
                            </div>

                            <!-- Fee Summary -->
                            <div class="mt-4 bg-gray-50 rounded-xl p-3 border text-xs space-y-1.5" x-show="amount && parseFloat(amount) > 0">
                                <div class="flex justify-between text-gray-600">
                                    <span>Withdrawal Amount:</span>
                                    <span class="font-bold font-mono" x-text="'$' + parseFloat(amount).toFixed(2)"></span>
                                </div>
                                <div class="flex justify-between text-gray-600">
                                    <span>Processing Fee:</span>
                                    <span class="font-bold font-mono text-red-500" x-text="'$' + fee.toFixed(2)"></span>
                                </div>
                                <div class="flex justify-between text-gray-800 border-t pt-1.5 font-bold">
                                    <span>Total Deduction:</span>
                                    <span class="font-mono text-indigo-600" x-text="'$' + (parseFloat(amount) + fee).toFixed(2)"></span>
                                </div>
                            </div>
                        </div>

                        <!-- Info note -->
                        <div class="bg-red-50 border border-red-100 rounded-xl p-4 text-xs text-red-800 flex items-start space-x-2">
                            <i class="fas fa-info-circle mt-0.5 text-red-500"></i>
                            <div>
                                <span class="font-bold">Important:</span> Withdrawal requests are processed manually by our administrators. Verification typically takes up to 24 hours. Ensure your wallet address matches the selected network.
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" :disabled="!amount || parseFloat(amount) <= 0 || (parseFloat(amount) + fee) > portfolioValue"
                                class="w-full py-3 bg-red-600 hover:bg-red-700 disabled:opacity-50 disabled:cursor-not-allowed text-white font-bold rounded-xl shadow-lg transition-all duration-200 hover:shadow-xl focus:ring-2 focus:ring-red-500">
                            <i class="fas fa-paper-plane mr-2"></i> Submit Withdrawal Request
                        </button>
                    </form>
                </div>
            </div>

            <!-- Bottom Section - Previous Withdrawal Requests -->
            <div class="bg-white rounded-2xl shadow-md p-6 border border-gray-100">
                <h2 class="text-xl font-bold text-gray-800 mb-6 flex items-center">
                    <i class="fas fa-history text-red-600 mr-2"></i>
                    Withdrawal History
                </h2>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Date</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Amount</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Fee</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Total Deducted</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Network</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Destination Address</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Payout TXID</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Remarks</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($withdrawals as $wth)
                             <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $wth->created_at->format('M d, Y h:i A') }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-900">${{ number_format($wth->amount, 2) }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-red-500">${{ number_format($wth->fee, 2) }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-indigo-600">${{ number_format($wth->amount + $wth->fee, 2) }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                    <span class="px-2 py-0.5 rounded-full text-xs font-semibold {{ $wth->network === 'BEP20' ? 'bg-blue-50 text-blue-700 border border-blue-100' : 'bg-red-50 text-red-700 border border-red-100' }}">
                                        {{ $wth->network }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-mono text-gray-500 select-all" title="{{ $wth->wallet_address }}">
                                    {{ Str::limit($wth->wallet_address, 16) }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-mono text-gray-500 select-all" title="{{ $wth->transaction_id ?: 'Not available' }}">
                                    {{ $wth->transaction_id ? Str::limit($wth->transaction_id, 16) : '-' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full 
                                        @if($wth->status === 'pending') bg-yellow-100 text-yellow-800
                                        @elseif($wth->status === 'approved') bg-green-100 text-green-800
                                        @else bg-red-100 text-red-800
                                        @endif">
                                        {{ ucfirst($wth->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-500">
                                    {{ $wth->remarks ?: '-' }}
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="9" class="px-6 py-8 text-center text-sm text-gray-500">
                                    <div class="flex flex-col items-center justify-center space-y-2">
                                        <i class="fas fa-inbox text-3xl text-gray-300"></i>
                                        <span>No withdrawal history found.</span>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
