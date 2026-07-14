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
                <div class="inline-flex items-center justify-center w-16 h-16 bg-blue-100 rounded-full mb-4 shadow-inner">
                    <i class="fas fa-wallet text-3xl text-blue-600"></i>
                </div>
                <h1 class="text-3xl font-bold text-gray-900 mb-2">Deposit Funds</h1>
                <p class="text-gray-600">Request a deposit to your account by transferring crypto on your preferred network</p>
            </div>

            <!-- Single Grid containing Setup & Verification -->
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 mb-8" x-data="{ 
                network: 'BEP20', 
                bep20Addr: '{{ $settings['bep20_address'] ?? '' }}',
                trc20Addr: '{{ $settings['trc20_address'] ?? '' }}',
                copied: false,
                fileName: '',
                copyText(text) {
                    navigator.clipboard.writeText(text);
                    this.copied = true;
                    setTimeout(() => this.copied = false, 2500);
                }
            }">
                
                <!-- Left Column - Deposit Network Details -->
                <div class="lg:col-span-5 bg-white rounded-2xl shadow-md p-6 border border-gray-100 flex flex-col justify-between">
                    <div>
                        <h2 class="text-xl font-bold text-gray-800 mb-4 flex items-center">
                            <span class="w-8 h-8 bg-blue-100 rounded-lg text-blue-600 flex items-center justify-center text-sm font-bold mr-2">1</span>
                            Payment Information
                        </h2>

                        <!-- Network Selector -->
                        <div class="mb-6">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Choose Network</label>
                            <div class="grid grid-cols-2 gap-4">
                                <button type="button" @click="network = 'BEP20'" 
                                    :class="network === 'BEP20' ? 'border-blue-500 bg-blue-50 text-blue-700 ring-2 ring-blue-500/20' : 'border-gray-200 bg-white text-gray-700 hover:bg-gray-50'"
                                    class="py-3 px-4 rounded-xl border font-bold text-center transition-all duration-200">
                                    <i class="fab fa-ethereum mr-2"></i>BEP20 (BSC)
                                </button>
                                <button type="button" @click="network = 'TRC20'" 
                                    :class="network === 'TRC20' ? 'border-blue-500 bg-blue-50 text-blue-700 ring-2 ring-blue-500/20' : 'border-gray-200 bg-white text-gray-700 hover:bg-gray-50'"
                                    class="py-3 px-4 rounded-xl border font-bold text-center transition-all duration-200">
                                    <i class="fas fa-bolt mr-2"></i>TRC20 (TRON)
                                </button>
                            </div>
                        </div>

                        <!-- Address and QR Codes -->
                        <div class="bg-gray-50 rounded-xl p-4 border border-gray-100 text-center mb-6">
                            <!-- BEP20 QR and Address -->
                            <div x-show="network === 'BEP20'" x-transition:enter="transition ease-out duration-300" class="space-y-4">
                                <p class="text-sm font-semibold text-blue-700 bg-blue-50/50 py-1 px-3 rounded-full inline-block">BEP20 Network Details</p>
                                <div class="flex justify-center">
                                    @if(!empty($settings['bep20_qr_code']))
                                        <img src="{{ asset('storage/' . $settings['bep20_qr_code']) }}" alt="BEP20 QR Code" class="w-48 h-48 object-contain rounded-lg border-2 border-white bg-white shadow-md">
                                    @else
                                        <div class="w-48 h-48 bg-gray-200 rounded-lg flex flex-col items-center justify-center text-gray-400 text-sm shadow-inner">
                                            <i class="fas fa-qrcode text-4xl mb-2"></i>
                                            <span>No QR code configured</span>
                                        </div>
                                    @endif
                                </div>
                                <div class="space-y-2">
                                    <p class="text-xs text-gray-500 font-semibold uppercase tracking-wider">BEP20 Deposit Address</p>
                                    <div class="flex items-center justify-between bg-white rounded-lg border p-2 shadow-inner">
                                        <code class="text-xs text-gray-700 font-mono select-all overflow-hidden text-ellipsis mr-2" x-text="bep20Addr"></code>
                                        <button type="button" @click="copyText(bep20Addr)" class="p-2 hover:bg-gray-100 rounded text-blue-600 focus:outline-none transition-colors">
                                            <i class="far fa-copy text-sm"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- TRC20 QR and Address -->
                            <div x-show="network === 'TRC20'" x-transition:enter="transition ease-out duration-300" class="space-y-4" style="display: none;">
                                <p class="text-sm font-semibold text-red-700 bg-red-50/50 py-1 px-3 rounded-full inline-block">TRC20 Network Details</p>
                                <div class="flex justify-center">
                                    @if(!empty($settings['trc20_qr_code']))
                                        <img src="{{ asset('storage/' . $settings['trc20_qr_code']) }}" alt="TRC20 QR Code" class="w-48 h-48 object-contain rounded-lg border-2 border-white bg-white shadow-md">
                                    @else
                                        <div class="w-48 h-48 bg-gray-200 rounded-lg flex flex-col items-center justify-center text-gray-400 text-sm shadow-inner">
                                            <i class="fas fa-qrcode text-4xl mb-2"></i>
                                            <span>No QR code configured</span>
                                        </div>
                                    @endif
                                </div>
                                <div class="space-y-2">
                                    <p class="text-xs text-gray-500 font-semibold uppercase tracking-wider">TRC20 Deposit Address</p>
                                    <div class="flex items-center justify-between bg-white rounded-lg border p-2 shadow-inner">
                                        <code class="text-xs text-gray-700 font-mono select-all overflow-hidden text-ellipsis mr-2" x-text="trc20Addr"></code>
                                        <button type="button" @click="copyText(trc20Addr)" class="p-2 hover:bg-gray-100 rounded text-blue-600 focus:outline-none transition-colors">
                                            <i class="far fa-copy text-sm"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Toast Copy Alert -->
                    <div x-show="copied" x-transition class="bg-green-600 text-white text-xs font-semibold py-2 px-4 rounded-lg text-center shadow-md transition-all duration-300">
                        <i class="fas fa-check-circle mr-1"></i> Address copied to clipboard!
                    </div>
                </div>

                <!-- Right Column - Submit Verification Details -->
                <div class="lg:col-span-7 bg-white rounded-2xl shadow-md p-6 border border-gray-100">
                    <h2 class="text-xl font-bold text-gray-800 mb-4 flex items-center">
                        <span class="w-8 h-8 bg-blue-100 rounded-lg text-blue-600 flex items-center justify-center text-sm font-bold mr-2">2</span>
                        Submit Deposit Proof
                    </h2>

                    <form action="{{ route('deposits.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                        @csrf
                        
                        <!-- Bind selected network to hidden input so controller knows -->
                        <input type="hidden" name="network" :value="network">

                        <!-- Input Amount -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Amount Deposited (USD) <span class="text-red-500">*</span></label>
                            <div class="relative rounded-xl shadow-sm">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <span class="text-gray-500 sm:text-sm">$</span>
                                </div>
                                <input type="number" name="amount" step="0.01" required 
                                       class="w-full pl-8 pr-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all" 
                                       placeholder="0.00" value="{{ old('amount') }}">
                            </div>
                            @error('amount')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Input Transaction ID -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Transaction ID / TXID <span class="text-red-500">*</span></label>
                            <input type="text" name="transaction_id" required 
                                   class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all" 
                                   placeholder="Enter blockchain hash/transaction ID" value="{{ old('transaction_id') }}">
                            @error('transaction_id')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Upload Screenshot File -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Payment Receipt Screenshot <span class="text-red-500">*</span></label>
                            <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-xl hover:border-blue-400 transition-colors relative"
                                 @dragover.prevent=""
                                 @drop.prevent="
                                     let files = $event.dataTransfer.files;
                                     if (files.length) {
                                         $refs.fileInput.files = files;
                                         fileName = files[0].name;
                                     }
                                 ">
                                <div class="space-y-1 text-center">
                                    <i class="fas fa-cloud-upload-alt text-4xl text-gray-400 mb-3" :class="fileName ? 'text-green-500' : 'text-gray-400'"></i>
                                    <div class="flex text-sm text-gray-600 justify-center">
                                        <label for="screenshot" class="relative cursor-pointer bg-white rounded-md font-semibold text-blue-600 hover:text-blue-500">
                                            <span x-text="fileName ? 'Change screenshot' : 'Upload screenshot'"></span>
                                            <input id="screenshot" x-ref="fileInput" name="screenshot" type="file" class="sr-only" required accept="image/*"
                                                   @change="fileName = $event.target.files[0] ? $event.target.files[0].name : ''">
                                        </label>
                                        <p class="pl-1" x-show="!fileName">or drag and drop</p>
                                    </div>
                                    <p class="text-xs text-gray-500" x-show="!fileName">PNG, JPG, JPEG up to 5MB</p>
                                    <p class="text-sm font-semibold text-green-600 flex items-center justify-center mt-2" x-show="fileName">
                                        <i class="fas fa-check-circle mr-1"></i> Ready: <span x-text="fileName" class="ml-1 text-gray-700 font-normal truncate max-w-xs"></span>
                                    </p>
                                </div>
                            </div>
                            @error('screenshot')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Info note -->
                        <div class="bg-blue-50 border border-blue-100 rounded-xl p-4 text-xs text-blue-800 flex items-start space-x-2">
                            <i class="fas fa-info-circle mt-0.5 text-blue-500"></i>
                            <div>
                                <span class="font-bold">Note:</span> Please make sure the transfer is complete before submitting the transaction proof. Our admins will verify the receipt on the blockchain, and funds will be credited to your account portfolio.
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" class="w-full py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-xl shadow-lg transition-all duration-200 hover:shadow-xl focus:ring-2 focus:ring-blue-500">
                            <i class="fas fa-paper-plane mr-2"></i> Submit Verification Request
                        </button>
                    </form>
                </div>
            </div>

            <!-- Bottom Section - Previous Deposit Requests -->
            <div class="bg-white rounded-2xl shadow-md p-6 border border-gray-100">
                <h2 class="text-xl font-bold text-gray-800 mb-6 flex items-center">
                    <i class="fas fa-history text-blue-600 mr-2"></i>
                    Deposit History
                </h2>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Date</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Amount</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Network</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">TXID / Transaction ID</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Remarks</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($deposits as $dep)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $dep->created_at->format('M d, Y h:i A') }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-900">${{ number_format($dep->amount, 2) }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                    <span class="px-2 py-0.5 rounded-full text-xs font-semibold {{ $dep->network === 'BEP20' ? 'bg-blue-50 text-blue-700 border border-blue-100' : 'bg-red-50 text-red-700 border border-red-100' }}">
                                        {{ $dep->network }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-mono text-gray-500 select-all" title="{{ $dep->transaction_id }}">
                                    {{ Str::limit($dep->transaction_id, 16) }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full 
                                        @if($dep->status === 'pending') bg-yellow-100 text-yellow-800
                                        @elseif($dep->status === 'approved') bg-green-100 text-green-800
                                        @else bg-red-100 text-red-800
                                        @endif">
                                        {{ ucfirst($dep->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-500">
                                    {{ $dep->remarks ?: '-' }}
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="px-6 py-8 text-center text-sm text-gray-500">
                                    <div class="flex flex-col items-center justify-center space-y-2">
                                        <i class="fas fa-inbox text-3xl text-gray-300"></i>
                                        <span>No deposit history found.</span>
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
