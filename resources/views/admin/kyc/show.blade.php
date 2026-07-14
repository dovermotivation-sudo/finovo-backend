<x-app-layout>
    <div class="py-8 bg-gray-50 min-h-screen">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="mb-6 flex items-center justify-between">
                <div>
                    <a href="{{ route('admin.kyc.index') }}" class="text-blue-600 hover:text-blue-800 mb-2 inline-block">
                        <i class="fas fa-arrow-left mr-2"></i>Back to KYC List
                    </a>
                    <h1 class="text-3xl font-bold text-gray-900">KYC Document Review</h1>
                </div>
                <span class="px-4 py-2 rounded-full text-sm font-medium
                    @if($kycDocument->status === 'pending') bg-yellow-100 text-yellow-800
                    @elseif($kycDocument->status === 'verified') bg-green-100 text-green-800
                    @else bg-red-100 text-red-800
                    @endif">
                    <i class="fas 
                        @if($kycDocument->status === 'pending') fa-clock
                        @elseif($kycDocument->status === 'verified') fa-check-circle
                        @else fa-times-circle
                        @endif mr-1"></i>
                    {{ ucfirst($kycDocument->status) }}
                </span>
            </div>

            @if(session('success'))
                <div class="mb-6 bg-green-50 border-l-4 border-green-400 p-4 rounded-lg">
                    <div class="flex">
                        <i class="fas fa-check-circle text-green-400 mt-1 mr-3"></i>
                        <p class="text-sm text-green-700">{{ session('success') }}</p>
                    </div>
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Left Column - User & Document Info -->
                <div class="lg:col-span-1 space-y-6">
                    <!-- User Information -->
                    <div class="bg-white rounded-xl shadow-sm p-6">
                        <h2 class="text-lg font-semibold text-gray-900 mb-4">User Information</h2>
                        <div class="flex items-center mb-4">
                            @if($kycDocument->user->profile_image_url)
                                <img class="h-16 w-16 rounded-full" src="{{ $kycDocument->user->profile_image_url }}" alt="">
                            @else
                                <div class="h-16 w-16 rounded-full bg-blue-500 flex items-center justify-center text-white text-xl font-semibold">
                                    {{ $kycDocument->user->initials }}
                                </div>
                            @endif
                            <div class="ml-4">
                                <p class="font-semibold text-gray-900">{{ $kycDocument->user->name }}</p>
                                <p class="text-sm text-gray-500">{{ $kycDocument->user->email }}</p>
                            </div>
                        </div>
                        <div class="space-y-3">
                            <div>
                                <p class="text-xs text-gray-500">Phone Number</p>
                                <p class="text-sm font-medium">{{ $kycDocument->user->phone_number ?? 'N/A' }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500">User ID</p>
                                <p class="text-sm font-medium">#{{ $kycDocument->user->id }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500">Registration Date</p>
                                <p class="text-sm font-medium">{{ $kycDocument->user->created_at->format('d M Y') }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Document Details -->
                    <div class="bg-white rounded-xl shadow-sm p-6">
                        <h2 class="text-lg font-semibold text-gray-900 mb-4">Document Details</h2>
                        <div class="space-y-3">
                            <div>
                                <p class="text-xs text-gray-500">Document Type</p>
                                <p class="text-sm font-medium">{{ $kycDocument->getDocumentTypeLabel() }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500">Document Number</p>
                                <p class="text-sm font-medium">{{ $kycDocument->document_number }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500">Submitted On</p>
                                <p class="text-sm font-medium">{{ $kycDocument->submitted_at->format('d M Y, h:i A') }}</p>
                            </div>
                            @if($kycDocument->verified_at)
                            <div>
                                <p class="text-xs text-gray-500">Reviewed On</p>
                                <p class="text-sm font-medium">{{ $kycDocument->verified_at->format('d M Y, h:i A') }}</p>
                            </div>
                            @endif
                            @if($kycDocument->verifier)
                            <div>
                                <p class="text-xs text-gray-500">Reviewed By</p>
                                <p class="text-sm font-medium">{{ $kycDocument->verifier->name }}</p>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Right Column - Document Images & Actions -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Document Images -->
                    <div class="bg-white rounded-xl shadow-sm p-6">
                        <h2 class="text-lg font-semibold text-gray-900 mb-4">Uploaded Documents</h2>
                        
                        <!-- Document Front -->
                        <div class="mb-6">
                            <p class="text-sm font-medium text-gray-700 mb-2">Document Front Side</p>
                            <div class="border border-gray-200 rounded-lg overflow-hidden">
                                @if(Str::endsWith($kycDocument->document_front_path, '.pdf'))
                                    <div class="bg-gray-100 p-8 text-center">
                                        <i class="fas fa-file-pdf text-6xl text-red-500 mb-3"></i>
                                        <p class="text-sm text-gray-600 mb-3">PDF Document</p>
                                        <a href="{{ asset('storage/' . $kycDocument->document_front_path) }}" target="_blank" 
                                           class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                                            <i class="fas fa-download mr-2"></i>Download PDF
                                        </a>
                                    </div>
                                @else
                                    <img src="{{ asset('storage/' . $kycDocument->document_front_path) }}" 
                                         alt="Document Front" 
                                         class="w-full h-auto cursor-pointer hover:opacity-90"
                                         onclick="openImageModal(this.src)">
                                @endif
                            </div>
                        </div>

                        <!-- Document Back -->
                        @if($kycDocument->document_back_path)
                        <div class="mb-6">
                            <p class="text-sm font-medium text-gray-700 mb-2">Document Back Side</p>
                            <div class="border border-gray-200 rounded-lg overflow-hidden">
                                @if(Str::endsWith($kycDocument->document_back_path, '.pdf'))
                                    <div class="bg-gray-100 p-8 text-center">
                                        <i class="fas fa-file-pdf text-6xl text-red-500 mb-3"></i>
                                        <p class="text-sm text-gray-600 mb-3">PDF Document</p>
                                        <a href="{{ asset('storage/' . $kycDocument->document_back_path) }}" target="_blank" 
                                           class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                                            <i class="fas fa-download mr-2"></i>Download PDF
                                        </a>
                                    </div>
                                @else
                                    <img src="{{ asset('storage/' . $kycDocument->document_back_path) }}" 
                                         alt="Document Back" 
                                         class="w-full h-auto cursor-pointer hover:opacity-90"
                                         onclick="openImageModal(this.src)">
                                @endif
                            </div>
                        </div>
                        @endif

                        <!-- Selfie -->
                        @if($kycDocument->selfie_path)
                        <div class="mb-6">
                            <p class="text-sm font-medium text-gray-700 mb-2">Selfie with Document</p>
                            <div class="border border-gray-200 rounded-lg overflow-hidden">
                                <img src="{{ asset('storage/' . $kycDocument->selfie_path) }}" 
                                     alt="Selfie" 
                                     class="w-full h-auto cursor-pointer hover:opacity-90"
                                     onclick="openImageModal(this.src)">
                            </div>
                        </div>
                        @endif
                    </div>

                    <!-- Admin Remarks -->
                    @if($kycDocument->remarks)
                    <div class="bg-white rounded-xl shadow-sm p-6">
                        <h2 class="text-lg font-semibold text-gray-900 mb-4">Admin Remarks</h2>
                        <p class="text-gray-700">{{ $kycDocument->remarks }}</p>
                    </div>
                    @endif

                    <!-- Action Buttons -->
                    @if($kycDocument->status === 'pending')
                    <div class="bg-white rounded-xl shadow-sm p-6">
                        <h2 class="text-lg font-semibold text-gray-900 mb-4">Review Actions</h2>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Approve -->
                            <form action="{{ route('admin.kyc.approve', $kycDocument->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to approve this KYC?')">
                                @csrf
                                <div class="mb-3">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Approval Remarks (Optional)</label>
                                    <textarea name="remarks" rows="3" 
                                              class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent"
                                              placeholder="Add any remarks..."></textarea>
                                </div>
                                <button type="submit" 
                                        class="w-full px-4 py-3 bg-green-600 text-white font-medium rounded-lg hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2">
                                    <i class="fas fa-check-circle mr-2"></i>Approve KYC
                                </button>
                            </form>

                            <!-- Reject -->
                            <form action="{{ route('admin.kyc.reject', $kycDocument->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to reject this KYC?')">
                                @csrf
                                <div class="mb-3">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Rejection Reason <span class="text-red-500">*</span></label>
                                    <textarea name="remarks" rows="3" required
                                              class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent"
                                              placeholder="Explain why this KYC is being rejected..."></textarea>
                                </div>
                                <button type="submit" 
                                        class="w-full px-4 py-3 bg-red-600 text-white font-medium rounded-lg hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2">
                                    <i class="fas fa-times-circle mr-2"></i>Reject KYC
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
            <button onclick="closeImageModal()" class="absolute top-4 right-4 text-white text-2xl hover:text-gray-300">
                <i class="fas fa-times"></i>
            </button>
            <img id="modalImage" src="" alt="Document" class="w-full h-auto rounded-lg">
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
