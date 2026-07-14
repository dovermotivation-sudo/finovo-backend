<x-app-layout>
    <div class="py-8 bg-gray-50 min-h-screen">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="text-center mb-8">
                <div class="inline-flex items-center justify-center w-16 h-16 bg-blue-100 rounded-full mb-4">
                    <i class="fas fa-user-check text-3xl text-blue-600"></i>
                </div>
                <h1 class="text-3xl font-bold text-gray-900 mb-2">KYC Status</h1>
                <p class="text-gray-600">View your identity verification status and details</p>
            </div>

            @if($kycDocument)
                <!-- Existing KYC Status -->
                <div class="bg-white rounded-xl shadow-sm p-6 mb-6">
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="text-xl font-semibold text-gray-900">Your KYC Status</h2>
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

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <div>
                            <p class="text-sm text-gray-500">Document Type</p>
                            <p class="font-medium">{{ $kycDocument->getDocumentTypeLabel() }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Document Number</p>
                            <p class="font-medium">{{ $kycDocument->document_number }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Submitted On</p>
                            <p class="font-medium">{{ $kycDocument->submitted_at?->format('d M Y, h:i A') }}</p>
                        </div>
                        @if($kycDocument->verified_at)
                        <div>
                            <p class="text-sm text-gray-500">{{ $kycDocument->status === 'verified' ? 'Verified' : 'Reviewed' }} On</p>
                            <p class="font-medium">{{ $kycDocument->verified_at->format('d M Y, h:i A') }}</p>
                        </div>
                        @endif
                    </div>

                    @if($kycDocument->remarks)
                    <div class="mt-4 p-4 bg-gray-50 rounded-lg">
                        <p class="text-sm text-gray-500 mb-1">Admin Remarks</p>
                        <p class="text-gray-700">{{ $kycDocument->remarks }}</p>
                    </div>
                    @endif

                    @if($kycDocument->status === 'rejected')
                    <div class="mt-6">
                        <a href="{{ route('kyc.application') }}" onclick="event.preventDefault(); document.getElementById('resubmit-form').submit();" 
                           class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                            <i class="fas fa-redo mr-2"></i>
                            Resubmit KYC
                        </a>
                        <form id="resubmit-form" action="{{ route('kyc.resubmit') }}" method="POST" class="hidden">
                            @csrf
                        </form>
                    </div>
                    @endif
                </div>

                <!-- Uploaded Documents Preview -->
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
                                     class="w-full h-auto">
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
                                     class="w-full h-auto">
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
                                 class="w-full h-auto">
                        </div>
                    </div>
                    @endif
                </div>
            @else
                <!-- No KYC yet -->
                <div class="bg-white rounded-xl shadow-sm p-6 text-center">
                    <div class="mb-4">
                        <i class="fas fa-id-card text-5xl text-gray-300"></i>
                    </div>
                    <h2 class="text-xl font-semibold text-gray-900 mb-2">No KYC Submitted</h2>
                    <p class="text-gray-600 mb-6">You haven't submitted your KYC documents yet.</p>
                    <a href="{{ route('kyc.application') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                        <i class="fas fa-paper-plane mr-2"></i>Start KYC Application
                    </a>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
