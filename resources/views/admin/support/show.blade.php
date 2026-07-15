<x-app-layout>
    <div class="py-8 bg-gray-50 min-h-screen">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Breadcrumbs / Back button -->
            <div class="mb-6">
                <a href="{{ route('admin.support.index') }}" class="inline-flex items-center text-sm font-semibold text-gray-500 hover:text-blue-600 transition-colors">
                    <i class="fas fa-arrow-left mr-2"></i> Back to Support Tickets
                </a>
            </div>

            <!-- Success Message -->
            @if(session('success'))
                <div class="mb-6 bg-green-50 border-l-4 border-green-400 p-4 rounded-lg shadow-sm">
                    <div class="flex">
                        <i class="fas fa-check-circle text-green-400 mt-1 mr-3"></i>
                        <p class="text-sm text-green-700 font-medium">{{ session('success') }}</p>
                    </div>
                </div>
            @endif

            <!-- Main Ticket Split Grid -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                
                <!-- Ticket Details & Conversation -->
                <div class="md:col-span-2 space-y-6">
                    
                    <!-- Ticket Main Card -->
                    <div class="bg-white rounded-2xl shadow-md border border-gray-100 overflow-hidden">
                        
                        <!-- Card Header -->
                        <div class="p-6 border-b border-gray-100 bg-gray-50/50 flex justify-between items-center">
                            <div>
                                <span class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Subject</span>
                                <h1 class="text-xl font-bold text-gray-900 mt-1">{{ $ticket->subject }}</h1>
                            </div>
                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full 
                                {{ $ticket->status === 'open' ? 'bg-yellow-100 text-yellow-800' : 'bg-green-100 text-green-800' }}">
                                {{ ucfirst($ticket->status) }}
                            </span>
                        </div>

                        <!-- Card Body (Conversation) -->
                        <div class="p-6 space-y-6">
                            
                            <!-- User Message -->
                            <div class="flex items-start space-x-4">
                                <div class="flex-shrink-0 w-10 h-10 bg-blue-600 text-white rounded-full flex items-center justify-center font-bold">
                                    {{ substr($ticket->user->name, 0, 1) }}
                                </div>
                                <div class="flex-1 bg-gray-50 border border-gray-150 rounded-2xl p-5">
                                    <div class="flex justify-between items-center mb-2">
                                        <span class="font-bold text-gray-900">{{ $ticket->user->name }}</span>
                                        <span class="text-xs text-gray-400">{{ $ticket->created_at->format('M d, Y h:i A') }}</span>
                                    </div>
                                    <p class="text-gray-700 whitespace-pre-wrap text-sm leading-relaxed">{{ $ticket->message }}</p>

                                    <!-- Attachment -->
                                    @if($ticket->screenshot_path)
                                    <div class="mt-4 pt-4 border-t border-gray-200" x-data="{ lightbox: false }">
                                        <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Attached Receipt / Screenshot</p>
                                        <img src="{{ asset('storage/' . $ticket->screenshot_path) }}" 
                                             alt="Ticket Screenshot" 
                                             @click="lightbox = true"
                                             class="max-w-xs h-32 object-cover rounded-lg border border-gray-250 shadow-sm cursor-pointer hover:opacity-90 transition-opacity bg-white">
                                        
                                        <!-- Lightbox Modal -->
                                        <div x-show="lightbox" 
                                             @keydown.escape.window="lightbox = false" 
                                             class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black bg-opacity-75"
                                             style="display: none;">
                                            <div class="relative max-w-4xl w-full" @click.away="lightbox = false">
                                                <img src="{{ asset('storage/' . $ticket->screenshot_path) }}" alt="Receipt Screenshot" class="w-full h-auto max-h-[85vh] object-contain rounded-lg">
                                                <button type="button" @click="lightbox = false" class="absolute top-4 right-4 bg-white text-gray-800 rounded-full p-2 hover:bg-gray-100 focus:outline-none shadow-md">
                                                    <i class="fas fa-times text-xl"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                </div>
                            </div>

                            <!-- Existing Admin Reply -->
                            @if($ticket->admin_reply)
                            <div class="flex items-start space-x-4 justify-end">
                                <div class="flex-1 bg-green-50 border border-green-200 rounded-2xl p-5 text-right">
                                    <div class="flex justify-between items-center mb-2">
                                        <span class="text-xs text-gray-400">{{ $ticket->updated_at->format('M d, Y h:i A') }}</span>
                                        <span class="font-bold text-green-800">Your Response</span>
                                    </div>
                                    <p class="text-gray-700 whitespace-pre-wrap text-sm leading-relaxed text-left">{{ $ticket->admin_reply }}</p>
                                </div>
                                <div class="flex-shrink-0 w-10 h-10 bg-green-600 text-white rounded-full flex items-center justify-center font-bold">
                                    A
                                </div>
                            </div>
                            @endif

                        </div>
                    </div>

                    <!-- Reply Form Card -->
                    <div class="bg-white rounded-2xl shadow-md border border-gray-100 p-6">
                        <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
                            <i class="fas fa-reply text-blue-600 mr-2"></i>
                            {{ $ticket->admin_reply ? 'Update Response' : 'Formulate Ticket Reply' }}
                        </h3>

                        <form action="{{ route('admin.support.reply', $ticket->id) }}" method="POST" class="space-y-4">
                            @csrf
                            
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Response Message <span class="text-red-500">*</span></label>
                                <textarea name="admin_reply" rows="5" required
                                          class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all" 
                                          placeholder="Type your response to the user here...">{{ old('admin_reply', $ticket->admin_reply) }}</textarea>
                                @error('admin_reply')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <button type="submit" class="w-full py-3 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-xl shadow-md transition-all duration-200 hover:shadow-lg">
                                <i class="fas fa-paper-plane mr-2"></i> Send Reply & Mark Resolved
                            </button>
                        </form>
                    </div>

                </div>

                <!-- Client Profile Metadata Card (Right Column) -->
                <div class="space-y-6">
                    <div class="bg-white rounded-2xl shadow-md border border-gray-100 p-6">
                        <h3 class="text-lg font-bold text-gray-800 border-b border-gray-100 pb-3 mb-4 flex items-center">
                            <i class="fas fa-user text-blue-600 mr-2"></i>
                            Client Information
                        </h3>

                        <div class="space-y-4 text-sm text-gray-650">
                            <div>
                                <p class="text-xs text-gray-400 font-semibold uppercase tracking-wider">Name</p>
                                <p class="font-bold text-gray-800 text-base">{{ $ticket->user->name }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-400 font-semibold uppercase tracking-wider">Email Address</p>
                                <p class="font-mono text-gray-700 select-all">{{ $ticket->user->email }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-400 font-semibold uppercase tracking-wider">Account Role</p>
                                <p class="capitalize bg-blue-50 text-blue-800 border border-blue-100 rounded px-2 py-0.5 inline-block text-xs font-semibold mt-1">
                                    {{ str_replace('_', ' ', $ticket->user->role) }}
                                </p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-400 font-semibold uppercase tracking-wider">Portfolio Balance</p>
                                <p class="font-bold text-gray-800 text-base">${{ number_format($ticket->user->portfolio_value, 2) }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-400 font-semibold uppercase tracking-wider">Opened At</p>
                                <p class="text-gray-600">{{ $ticket->created_at->format('M d, Y h:i A') }}</p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>
</x-app-layout>
