<x-app-layout>
    <div class="py-8 bg-gray-50 min-h-screen">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Success/Error Messages -->
            @if(session('success'))
                <div class="mb-6 bg-green-50 border-l-4 border-green-400 p-4 rounded-lg">
                    <div class="flex">
                        <i class="fas fa-check-circle text-green-400 mt-1 mr-3"></i>
                        <p class="text-sm text-green-700">{{ session('success') }}</p>
                    </div>
                </div>
            @endif

            @if(session('error'))
                <div class="mb-6 bg-red-50 border-l-4 border-red-400 p-4 rounded-lg">
                    <div class="flex">
                        <i class="fas fa-exclamation-circle text-red-400 mt-1 mr-3"></i>
                        <p class="text-sm text-red-700">{{ session('error') }}</p>
                    </div>
                </div>
            @endif

            <!-- Header -->
            <div class="text-center mb-8">
                <div class="inline-flex items-center justify-center w-16 h-16 bg-blue-100 rounded-full mb-4">
                    <i class="fas fa-user-check text-3xl text-blue-600"></i>
                </div>
                <h1 class="text-3xl font-bold text-gray-900 mb-2">KYC Verification</h1>
                <p class="text-gray-600">Complete your identity verification to unlock all features</p>
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
                            <p class="font-medium">{{ $kycDocument->submitted_at->format('d M Y, h:i A') }}</p>
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
            @else
                <!-- KYC Upload Form -->
                <div class="bg-white rounded-xl shadow-sm p-6">
                    <form action="{{ route('kyc.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <!-- Document Type -->
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Document Type <span class="text-red-500">*</span>
                            </label>
                            <select name="document_type" id="document_type" required 
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                    onchange="updateDocumentHint()">
                                <option value="">Select Document Type</option>
                                <option value="aadhaar">Aadhaar Card</option>
                                <option value="pan">PAN Card</option>
                                <option value="driving_license">Driving License</option>
                                <option value="passport">Passport</option>
                                <option value="voter_id">Voter ID</option>
                            </select>
                            @error('document_type')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Document Number -->
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Document Number <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="document_number" id="document_number" required 
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                   placeholder="Enter your document number">
                            <p id="document_hint" class="mt-2 text-sm text-gray-500"></p>
                            @error('document_number')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Document Front -->
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Document Front Side <span class="text-red-500">*</span>
                            </label>
                            <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-lg hover:border-blue-400 transition-colors">
                                <div class="space-y-1 text-center">
                                    <i class="fas fa-cloud-upload-alt text-4xl text-gray-400 mb-3"></i>
                                    <div class="flex text-sm text-gray-600">
                                        <label for="document_front" class="relative cursor-pointer bg-white rounded-md font-medium text-blue-600 hover:text-blue-500">
                                            <span>Upload a file</span>
                                            <input id="document_front" name="document_front" type="file" class="sr-only" required accept=".jpg,.jpeg,.png,.pdf">
                                        </label>
                                        <p class="pl-1">or drag and drop</p>
                                    </div>
                                    <p class="text-xs text-gray-500">JPG, PNG, PDF up to 5MB</p>
                                </div>
                            </div>
                            @error('document_front')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Document Back -->
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Document Back Side (Optional)
                            </label>
                            <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-lg hover:border-blue-400 transition-colors">
                                <div class="space-y-1 text-center">
                                    <i class="fas fa-cloud-upload-alt text-4xl text-gray-400 mb-3"></i>
                                    <div class="flex text-sm text-gray-600">
                                        <label for="document_back" class="relative cursor-pointer bg-white rounded-md font-medium text-blue-600 hover:text-blue-500">
                                            <span>Upload a file</span>
                                            <input id="document_back" name="document_back" type="file" class="sr-only" accept=".jpg,.jpeg,.png,.pdf">
                                        </label>
                                        <p class="pl-1">or drag and drop</p>
                                    </div>
                                    <p class="text-xs text-gray-500">JPG, PNG, PDF up to 5MB</p>
                                </div>
                            </div>
                            @error('document_back')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Selfie -->
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Selfie with Document (Optional)
                            </label>
                            <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-lg hover:border-blue-400 transition-colors">
                                <div class="space-y-1 text-center">
                                    <i class="fas fa-camera text-4xl text-gray-400 mb-3"></i>
                                    <div class="flex text-sm text-gray-600">
                                        <label for="selfie" class="relative cursor-pointer bg-white rounded-md font-medium text-blue-600 hover:text-blue-500">
                                            <span>Upload a photo</span>
                                            <input id="selfie" name="selfie" type="file" class="sr-only" accept=".jpg,.jpeg,.png">
                                        </label>
                                        <p class="pl-1">or drag and drop</p>
                                    </div>
                                    <p class="text-xs text-gray-500">JPG, PNG up to 5MB</p>
                                </div>
                            </div>
                            @error('selfie')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Submit Button -->
                        <div class="flex items-center justify-between">
                            <a href="{{ route('user.dashboard') }}" class="text-gray-600 hover:text-gray-800">
                                <i class="fas fa-arrow-left mr-2"></i>Back to Dashboard
                            </a>
                            <button type="submit" 
                                    class="px-6 py-3 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors">
                                <i class="fas fa-paper-plane mr-2"></i>Submit KYC
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Information Box -->
                <div class="mt-6 bg-blue-50 border border-blue-200 rounded-lg p-4">
                    <h3 class="font-semibold text-blue-900 mb-2">
                        <i class="fas fa-info-circle mr-2"></i>Important Information
                    </h3>
                    <ul class="text-sm text-blue-800 space-y-1">
                        <li>• Ensure all documents are clear and readable</li>
                        <li>• Accepted formats: JPG, PNG, PDF</li>
                        <li>• Maximum file size: 5MB per file</li>
                        <li>• Verification typically takes 24-48 hours</li>
                        <li>• You will be notified via email once verified</li>
                    </ul>
                </div>
            @endif
        </div>
    </div>

    <script>
        function updateDocumentHint() {
            const docType = document.getElementById('document_type').value;
            const hintElement = document.getElementById('document_hint');
            const numberInput = document.getElementById('document_number');
            
            const hints = {
                'aadhaar': {
                    text: '📋 Format: 12 digits (cannot start with 0 or 1). Example: 234567891234',
                    placeholder: 'Enter 12-digit Aadhaar number',
                    pattern: '[2-9][0-9]{11}'
                },
                'pan': {
                    text: '📋 Format: 5 letters, 4 digits, 1 letter (all uppercase). Example: ABCDE1234F',
                    placeholder: 'Enter PAN number (e.g., ABCDE1234F)',
                    pattern: '[A-Z]{5}[0-9]{4}[A-Z]{1}'
                },
                'driving_license': {
                    text: '📋 Format: 2 letters, 2 digits, 11 digits. Example: MH0120200012345',
                    placeholder: 'Enter Driving License number',
                    pattern: '[A-Z]{2}[0-9]{13}'
                },
                'passport': {
                    text: '📋 Format: 1 letter followed by 7 digits. Example: A1234567',
                    placeholder: 'Enter Passport number (e.g., A1234567)',
                    pattern: '[A-Z]{1}[0-9]{7}'
                },
                'voter_id': {
                    text: '📋 Format: 3 letters followed by 7 digits. Example: ABC1234567',
                    placeholder: 'Enter Voter ID (e.g., ABC1234567)',
                    pattern: '[A-Z]{3}[0-9]{7}'
                }
            };
            
            if (docType && hints[docType]) {
                hintElement.innerHTML = '<i class="fas fa-info-circle text-blue-500 mr-1"></i>' + hints[docType].text;
                hintElement.classList.remove('text-gray-500');
                hintElement.classList.add('text-blue-600', 'bg-blue-50', 'p-3', 'rounded-lg');
                numberInput.placeholder = hints[docType].placeholder;
                numberInput.setAttribute('pattern', hints[docType].pattern);
                numberInput.style.textTransform = (docType === 'pan' || docType === 'driving_license' || docType === 'passport' || docType === 'voter_id') ? 'uppercase' : 'none';
            } else {
                hintElement.innerHTML = '';
                hintElement.classList.remove('text-blue-600', 'bg-blue-50', 'p-3', 'rounded-lg');
                numberInput.placeholder = 'Enter your document number';
                numberInput.removeAttribute('pattern');
                numberInput.style.textTransform = 'none';
            }
        }

        // Auto-uppercase for specific document types
        document.getElementById('document_number').addEventListener('input', function(e) {
            const docType = document.getElementById('document_type').value;
            if (['pan', 'driving_license', 'passport', 'voter_id'].includes(docType)) {
                e.target.value = e.target.value.toUpperCase();
            }
        });
    </script>
</x-app-layout>
