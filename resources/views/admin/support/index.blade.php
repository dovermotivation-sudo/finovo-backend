<x-app-layout>
    <div class="py-8 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Page Header -->
            <div class="mb-6 flex flex-wrap justify-between items-center gap-4">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Support Ticket Management</h1>
                    <p class="text-gray-600 mt-1">Review user requests, send assistance replies, and track resolution states</p>
                </div>
            </div>

            <!-- Search and Filter Bar -->
            <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-200 mb-6 flex flex-wrap items-center justify-between gap-4">
                <!-- Search Form -->
                <form action="{{ route('admin.support.index') }}" method="GET" class="flex-1 min-w-[300px] flex items-center space-x-2">
                    <!-- Retain status filter in search if any -->
                    @if(request('status'))
                        <input type="hidden" name="status" value="{{ request('status') }}">
                    @endif
                    <div class="relative flex-1">
                        <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
                            <i class="fas fa-search"></i>
                        </span>
                        <input type="text" name="search" value="{{ request('search') }}"
                               placeholder="Search by subject, message, name, or email..."
                               class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>
                    <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors font-medium">
                        Search
                    </button>
                    @if(request('search') || request('status'))
                        <a href="{{ route('admin.support.index') }}" class="px-3 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors">
                            Clear
                        </a>
                    @endif
                </form>

                <!-- Status Filter Options -->
                <div class="flex items-center space-x-2">
                    <a href="{{ route('admin.support.index', array_merge(request()->except('page'), ['status' => ''])) }}" 
                       class="px-4 py-2 rounded-lg text-sm font-semibold transition-colors {{ !request('status') ? 'bg-blue-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                        All
                    </a>
                    <a href="{{ route('admin.support.index', array_merge(request()->except('page'), ['status' => 'open'])) }}" 
                       class="px-4 py-2 rounded-lg text-sm font-semibold transition-colors {{ request('status') === 'open' ? 'bg-blue-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                        Open
                    </a>
                    <a href="{{ route('admin.support.index', array_merge(request()->except('page'), ['status' => 'resolved'])) }}" 
                       class="px-4 py-2 rounded-lg text-sm font-semibold transition-colors {{ request('status') === 'resolved' ? 'bg-blue-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                        Resolved
                    </a>
                </div>
            </div>

            <!-- Tickets Table Card -->
            <div class="bg-white rounded-xl shadow-md border border-gray-200 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Date</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Client Name & Email</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Subject</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Preview</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Attachment</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Action</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($tickets as $t)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                    {{ $t->created_at->format('M d, Y h:i A') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                    <div class="font-bold text-gray-900">{{ $t->user->name }}</div>
                                    <div class="text-xs text-gray-500">{{ $t->user->email }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-900">
                                    {{ $t->subject }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ Str::limit($t->message, 30) }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full 
                                        {{ $t->status === 'open' ? 'bg-yellow-100 text-yellow-800' : 'bg-green-100 text-green-800' }}">
                                        {{ ucfirst($t->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    @if($t->screenshot_path)
                                        <span class="text-blue-600 font-semibold"><i class="fas fa-paperclip mr-1"></i>Image</span>
                                    @else
                                        <span class="text-gray-400">-</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                    <a href="{{ route('admin.support.show', $t->id) }}" class="text-blue-600 hover:text-blue-800 font-bold flex items-center space-x-1">
                                        <i class="fas fa-reply"></i> <span>Reply / Manage</span>
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="px-6 py-8 text-center text-sm text-gray-500">
                                    <div class="flex flex-col items-center justify-center space-y-2">
                                        <i class="fas fa-inbox text-3xl text-gray-300"></i>
                                        <span>No support tickets found.</span>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="mt-4 px-6 py-4 bg-gray-50 border-t">
                    {{ $tickets->links() }}
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
