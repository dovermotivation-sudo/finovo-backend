<x-app-layout>
    <div class="py-8 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-900">KYC Management</h1>
                <p class="text-gray-600 mt-2">Review and manage user KYC verification requests</p>
            </div>

            @if(session('success'))
                <div class="mb-6 bg-green-50 border-l-4 border-green-400 p-4 rounded-lg">
                    <div class="flex">
                        <i class="fas fa-check-circle text-green-400 mt-1 mr-3"></i>
                        <p class="text-sm text-green-700">{{ session('success') }}</p>
                    </div>
                </div>
            @endif

            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
                <div class="bg-white rounded-xl shadow-sm p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-500">Total Submissions</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $kycDocuments->total() }}</p>
                        </div>
                        <div class="bg-blue-100 rounded-full p-3">
                            <i class="fas fa-file-alt text-blue-600 text-xl"></i>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-sm p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-500">Pending Review</p>
                            <p class="text-2xl font-bold text-yellow-600">{{ $pendingCount }}</p>
                        </div>
                        <div class="bg-yellow-100 rounded-full p-3">
                            <i class="fas fa-clock text-yellow-600 text-xl"></i>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-sm p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-500">Verified</p>
                            <p class="text-2xl font-bold text-green-600">{{ \App\Models\KycDocument::where('status', 'verified')->count() }}</p>
                        </div>
                        <div class="bg-green-100 rounded-full p-3">
                            <i class="fas fa-check-circle text-green-600 text-xl"></i>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-sm p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-500">Rejected</p>
                            <p class="text-2xl font-bold text-red-600">{{ \App\Models\KycDocument::where('status', 'rejected')->count() }}</p>
                        </div>
                        <div class="bg-red-100 rounded-full p-3">
                            <i class="fas fa-times-circle text-red-600 text-xl"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Filter Tabs -->
            <div class="bg-white rounded-xl shadow-sm mb-6">
                <div class="border-b border-gray-200">
                    <form id="deleteForm" action="{{ route('admin.kyc.delete') }}" method="POST">
                        @csrf
                        @method('DELETE')
                        
                        <div class="p-4 flex justify-between items-center">
                            <div class="flex items-center space-x-4">
                                <input type="checkbox" id="selectAll" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500">
                                <label for="selectAll" class="text-sm font-medium text-gray-700">Select All</label>
                            </div>
                            <button type="button" id="deleteBtn" class="px-4 py-2 bg-red-600 text-white text-sm font-medium rounded-lg shadow hover:bg-red-700 transition-colors disabled:bg-gray-400 disabled:cursor-not-allowed" disabled>
                                Delete Selected
                            </button>
                        </div>

                        <nav class="flex space-x-8 px-6" aria-label="Tabs">
                            <a href="{{ route('admin.kyc.index', ['status' => 'all']) }}" 
                               class="border-b-2 {{ $status === 'all' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} py-4 px-1 text-sm font-medium">
                                All Applications
                            </a>
                            <a href="{{ route('admin.kyc.index', ['status' => 'pending']) }}" 
                               class="border-b-2 {{ $status === 'pending' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} py-4 px-1 text-sm font-medium">
                                Pending
                                @if($pendingCount > 0)
                                    <span class="ml-2 bg-yellow-100 text-yellow-800 py-0.5 px-2 rounded-full text-xs">{{ $pendingCount }}</span>
                                @endif
                            </a>
                            <a href="{{ route('admin.kyc.index', ['status' => 'verified']) }}" 
                               class="border-b-2 {{ $status === 'verified' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} py-4 px-1 text-sm font-medium">
                                Verified
                            </a>
                            <a href="{{ route('admin.kyc.index', ['status' => 'rejected']) }}" 
                               class="border-b-2 {{ $status === 'rejected' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} py-4 px-1 text-sm font-medium">
                                Rejected
                            </a>
                        </nav>

                        <!-- KYC List -->
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Select</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Document Type</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Document Number</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Submitted</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @forelse($kycDocuments as $kyc)
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <input type="checkbox" name="kyc_documents[]" value="{{ $kyc->id }}" class="kyc-checkbox w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500">
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="flex items-center">
                                                    <div class="flex-shrink-0 h-10 w-10">
                                                        @if($kyc->user->profile_image_url)
                                                            <img class="h-10 w-10 rounded-full" src="{{ $kyc->user->profile_image_url }}" alt="">
                                                        @else
                                                            <div class="h-10 w-10 rounded-full bg-blue-500 flex items-center justify-center text-white font-semibold">
                                                                {{ $kyc->user->initials }}
                                                            </div>
                                                        @endif
                                                    </div>
                                                    <div class="ml-4">
                                                        <div class="text-sm font-medium text-gray-900">{{ $kyc->user->name }}</div>
                                                        <div class="text-sm text-gray-500">{{ $kyc->user->email }}</div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900">{{ $kyc->getDocumentTypeLabel() }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900">{{ $kyc->document_number }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900">{{ $kyc->submitted_at->format('d M Y') }}</div>
                                                <div class="text-sm text-gray-500">{{ $kyc->submitted_at->format('h:i A') }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                    @if($kyc->status === 'pending') bg-yellow-100 text-yellow-800
                                                    @elseif($kyc->status === 'verified') bg-green-100 text-green-800
                                                    @else bg-red-100 text-red-800
                                                    @endif">
                                                    {{ ucfirst($kyc->status) }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                <a href="{{ route('admin.kyc.show', $kyc->id) }}" 
                                                   class="text-blue-600 hover:text-blue-900 mr-3">
                                                    <i class="fas fa-eye mr-1"></i>View
                                                </a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="px-6 py-12 text-center">
                                                <i class="fas fa-inbox text-4xl text-gray-300 mb-3"></i>
                                                <p class="text-gray-500">No KYC applications found</p>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        @if($kycDocuments->hasPages())
                            <div class="px-6 py-4 border-t border-gray-200">
                                {{ $kycDocuments->links() }}
                            </div>
                        @endif
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const selectAllCheckbox = document.getElementById('selectAll');
    const kycCheckboxes = document.querySelectorAll('.kyc-checkbox');
    const deleteBtn = document.getElementById('deleteBtn');
    const deleteForm = document.getElementById('deleteForm');

    function updateDeleteButton() {
        const checkedBoxes = document.querySelectorAll('.kyc-checkbox:checked');
        deleteBtn.disabled = checkedBoxes.length === 0;
    }

    selectAllCheckbox.addEventListener('change', function() {
        kycCheckboxes.forEach(checkbox => {
            checkbox.checked = this.checked;
        });
        updateDeleteButton();
    });

    kycCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            const allChecked = Array.from(kycCheckboxes).every(cb => cb.checked);
            const someChecked = Array.from(kycCheckboxes).some(cb => cb.checked);
            
            selectAllCheckbox.checked = allChecked;
            selectAllCheckbox.indeterminate = someChecked && !allChecked;
            
            updateDeleteButton();
        });
    });

    deleteBtn.addEventListener('click', function() {
        const checkedBoxes = document.querySelectorAll('.kyc-checkbox:checked');
        const count = checkedBoxes.length;
        
        if (count === 0) {
            return;
        }

        if (confirm(`Are you sure you want to delete ${count} KYC document(s)? This action cannot be undone and will permanently remove all associated documents.`)) {
            deleteForm.submit();
        }
    });
});
</script>
