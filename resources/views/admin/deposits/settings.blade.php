<x-app-layout>
    <div class="py-8 bg-gray-50 min-h-screen">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="mb-6 bg-green-50 border-l-4 border-green-400 p-4 rounded-lg shadow-sm">
                    <div class="flex">
                        <i class="fas fa-check-circle text-green-400 mt-1 mr-3"></i>
                        <p class="text-sm text-green-700 font-medium">{{ session('success') }}</p>
                    </div>
                </div>
            @endif

            <!-- Header -->
            <div class="mb-8 flex justify-between items-center">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 mb-2">Deposit Settings</h1>
                    <p class="text-gray-600">Configure your BEP20 and TRC20 network addresses and QR codes for user deposits</p>
                </div>
                <a href="{{ route('admin.deposits.index') }}" class="px-4 py-2 bg-white border rounded-xl hover:bg-gray-50 text-sm font-semibold transition-colors flex items-center shadow-sm">
                    <i class="fas fa-list mr-2"></i> Deposits List
                </a>
            </div>

            <!-- Form -->
            <div class="bg-white rounded-2xl shadow-md border border-gray-100 p-6">
                <form action="{{ route('admin.deposits.settings.update') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
                    @csrf

                    <!-- BEP20 Network Configuration -->
                    <div class="border-b border-gray-100 pb-8">
                        <h2 class="text-xl font-bold text-gray-800 mb-4 flex items-center text-blue-600">
                            <i class="fab fa-ethereum mr-2"></i> BEP20 (Binance Smart Chain) Configuration
                        </h2>
                        
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <!-- Left Column: inputs -->
                            <div class="md:col-span-2 space-y-4">
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">BEP20 Wallet Address <span class="text-red-500">*</span></label>
                                    <input type="text" name="bep20_address" required 
                                           class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent font-mono text-sm" 
                                           value="{{ old('bep20_address', $settings['bep20_address'] ?? '') }}" placeholder="0x...">
                                    @error('bep20_address')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">BEP20 QR Code File</label>
                                    <input type="file" name="bep20_qr_code" accept="image/*"
                                           class="w-full text-sm text-gray-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 transition-colors">
                                    <p class="mt-1 text-xs text-gray-500">Upload a square image format (JPG, PNG, JPEG) of your QR Code.</p>
                                    @error('bep20_qr_code')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            
                            <!-- Right Column: current QR code preview -->
                            <div class="flex flex-col items-center justify-center p-4 bg-gray-50 rounded-xl border border-gray-100 text-center">
                                <span class="text-xs text-gray-400 font-semibold mb-2 uppercase tracking-wider">Current BEP20 QR</span>
                                @if(!empty($settings['bep20_qr_code']))
                                    <img src="{{ asset('storage/' . $settings['bep20_qr_code']) }}" alt="BEP20 QR Code" class="w-32 h-32 object-contain bg-white rounded-lg border p-1 shadow-sm">
                                @else
                                    <div class="w-32 h-32 bg-gray-200 rounded-lg flex flex-col items-center justify-center text-gray-400 text-xs shadow-inner">
                                        <i class="fas fa-qrcode text-2xl mb-1"></i>
                                        <span>No image</span>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- TRC20 Network Configuration -->
                    <div class="pb-4">
                        <h2 class="text-xl font-bold text-gray-800 mb-4 flex items-center text-red-600">
                            <i class="fas fa-bolt mr-2"></i> TRC20 (TRON) Configuration
                        </h2>
                        
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <!-- Left Column: inputs -->
                            <div class="md:col-span-2 space-y-4">
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">TRC20 Wallet Address <span class="text-red-500">*</span></label>
                                    <input type="text" name="trc20_address" required 
                                           class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent font-mono text-sm" 
                                           value="{{ old('trc20_address', $settings['trc20_address'] ?? '') }}" placeholder="T...">
                                    @error('trc20_address')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">TRC20 QR Code File</label>
                                    <input type="file" name="trc20_qr_code" accept="image/*"
                                           class="w-full text-sm text-gray-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-red-50 file:text-red-700 hover:file:bg-red-100 transition-colors">
                                    <p class="mt-1 text-xs text-gray-500">Upload a square image format (JPG, PNG, JPEG) of your QR Code.</p>
                                    @error('trc20_qr_code')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            
                            <!-- Right Column: current QR code preview -->
                            <div class="flex flex-col items-center justify-center p-4 bg-gray-50 rounded-xl border border-gray-100 text-center">
                                <span class="text-xs text-gray-400 font-semibold mb-2 uppercase tracking-wider">Current TRC20 QR</span>
                                @if(!empty($settings['trc20_qr_code']))
                                    <img src="{{ asset('storage/' . $settings['trc20_qr_code']) }}" alt="TRC20 QR Code" class="w-32 h-32 object-contain bg-white rounded-lg border p-1 shadow-sm">
                                @else
                                    <div class="w-32 h-32 bg-gray-200 rounded-lg flex flex-col items-center justify-center text-gray-400 text-xs shadow-inner">
                                        <i class="fas fa-qrcode text-2xl mb-1"></i>
                                        <span>No image</span>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="pt-6 border-t border-gray-100 flex justify-end">
                        <button type="submit" class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-xl shadow-md hover:shadow-lg transition-all duration-200">
                            <i class="fas fa-save mr-2"></i> Save Settings
                        </button>
                    </div>

                </form>
            </div>

        </div>
    </div>
</x-app-layout>
