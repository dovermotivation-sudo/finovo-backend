<x-app-layout>
    <div class="py-8 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Success/Error Alert messages -->
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
            <div class="mb-8 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 mb-2">Withdrawal Management</h1>
                    <p class="text-gray-600">Review and verify user cryptocurrency withdrawal requests</p>
                </div>
            </div>

            <!-- Stats/Metrics Overview -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 mb-8">
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 flex justify-between items-center">
                    <div>
                        <p class="text-xs text-gray-500 font-semibold uppercase tracking-wider mb-1">Pending Processing</p>
                        <h3 class="text-3xl font-bold text-yellow-600">{{ $pendingCount }}</h3>
                    </div>
                    <div class="p-3 bg-yellow-50 rounded-xl">
                        <i class="fas fa-clock text-yellow-500 text-xl"></i>
                    </div>
                </div>
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 flex justify-between items-center">
                    <div>
                        <p class="text-xs text-gray-500 font-semibold uppercase tracking-wider mb-1">Approved Withdrawals</p>
                        <h3 class="text-3xl font-bold text-green-600">
                            ${{ number_format(\App\Models\Withdrawal::where('status', 'approved')->sum('amount'), 2) }}
                        </h3>
                    </div>
                    <div class="p-3 bg-green-50 rounded-xl">
                        <i class="fas fa-check-circle text-green-500 text-xl"></i>
                    </div>
                </div>
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 flex justify-between items-center">
                    <div>
                        <p class="text-xs text-gray-500 font-semibold uppercase tracking-wider mb-1">Total Requests</p>
                        <h3 class="text-3xl font-bold text-blue-600">{{ \App\Models\Withdrawal::count() }}</h3>
                    </div>
                    <div class="p-3 bg-blue-50 rounded-xl">
                        <i class="fas fa-file-invoice-dollar text-blue-500 text-xl"></i>
                    </div>
                </div>
            </div>

            <!-- Filter Status Bar -->
            <div class="flex flex-wrap gap-2 mb-6">
                <a href="{{ route('admin.withdrawals.index', ['status' => 'all']) }}" 
                   class="px-4 py-2 rounded-xl text-sm font-semibold border transition-all duration-200 {{ $status === 'all' ? 'bg-gray-800 text-white border-gray-800' : 'bg-white text-gray-600 hover:bg-gray-50' }}">
                    All Withdrawals
                </a>
                <a href="{{ route('admin.withdrawals.index', ['status' => 'pending']) }}" 
                   class="px-4 py-2 rounded-xl text-sm font-semibold border transition-all duration-200 {{ $status === 'pending' ? 'bg-yellow-500 text-white border-yellow-500' : 'bg-white text-gray-600 hover:bg-gray-50' }}">
                    Pending ({{ $pendingCount }})
                </a>
                <a href="{{ route('admin.withdrawals.index', ['status' => 'approved']) }}" 
                   class="px-4 py-2 rounded-xl text-sm font-semibold border transition-all duration-200 {{ $status === 'approved' ? 'bg-green-600 text-white border-green-600' : 'bg-white text-gray-600 hover:bg-gray-50' }}">
                    Approved
                </a>
                <a href="{{ route('admin.withdrawals.index', ['status' => 'rejected']) }}" 
                   class="px-4 py-2 rounded-xl text-sm font-semibold border transition-all duration-200 {{ $status === 'rejected' ? 'bg-red-600 text-white border-red-600' : 'bg-white text-gray-600 hover:bg-gray-50' }}">
                    Rejected
                </a>
            </div>

            <!-- Withdrawals Table -->
            <div class="bg-white rounded-2xl shadow-md border border-gray-100 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">User</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Amount</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Network</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Destination Address</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Submitted</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Action</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($withdrawals as $wth)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-9 w-9 rounded-full bg-red-100 text-red-600 font-bold flex items-center justify-center text-sm shadow-sm">
                                            {{ strtoupper(substr($wth->user->name, 0, 1)) }}
                                        </div>
                                        <div class="ml-3">
                                            <div class="text-sm font-semibold text-gray-900">{{ $wth->user->name }}</div>
                                            <div class="text-xs text-gray-500">{{ $wth->user->email }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                    <div class="font-bold text-gray-900">${{ number_format($wth->amount, 2) }}</div>
                                    <div class="text-xs text-gray-500">+ ${{ number_format($wth->fee, 2) }} fee</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                    <span class="px-2 py-0.5 rounded-full text-xs font-semibold {{ $wth->network === 'BEP20' ? 'bg-blue-50 text-blue-700 border border-blue-100' : 'bg-red-50 text-red-700 border border-red-100' }}">
                                        {{ $wth->network }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-mono text-gray-500 select-all" title="{{ $wth->wallet_address }}">
                                    {{ Str::limit($wth->wallet_address, 16) }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                    {{ $wth->created_at->format('M d, Y h:i A') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full 
                                        @if($wth->status === 'pending') bg-yellow-100 text-yellow-800
                                        @elseif($wth->status === 'approved') bg-green-100 text-green-800
                                        @else bg-red-100 text-red-800
                                        @endif">
                                        {{ ucfirst($wth->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold">
                                    <a href="{{ route('admin.withdrawals.show', $wth->id) }}" class="text-blue-600 hover:text-blue-900 flex items-center gap-1">
                                        <i class="fas fa-eye"></i> View details
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="px-6 py-12 text-center text-sm text-gray-500">
                                    <div class="flex flex-col items-center justify-center space-y-2">
                                        <i class="fas fa-inbox text-4xl text-gray-300"></i>
                                        <span>No withdrawal requests found.</span>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($withdrawals->hasPages())
                <div class="px-6 py-4 border-t border-gray-100 bg-gray-50">
                    {{ $withdrawals->links() }}
                </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>
