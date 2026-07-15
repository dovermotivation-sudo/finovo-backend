<x-app-layout>
    <div class="py-8 bg-gray-50 min-h-screen">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Breadcrumbs / Back button -->
            <div class="mb-6">
                <a href="{{ route('support.index') }}" class="inline-flex items-center text-sm font-semibold text-gray-500 hover:text-indigo-600 transition-colors">
                    <i class="fas fa-arrow-left mr-2"></i> Back to Support Tickets
                </a>
            </div>

            <!-- Main Ticket Card -->
            <div class="bg-white rounded-2xl shadow-md border border-gray-100 overflow-hidden mb-6">
                
                <!-- Ticket Header -->
                <div class="p-6 border-b border-gray-100 bg-gray-50/50 flex flex-wrap justify-between items-center gap-4">
                    <div>
                        <span class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Ticket Subject</span>
                        <h1 class="text-2xl font-bold text-gray-900 mt-1">{{ $ticket->subject }}</h1>
                    </div>
                    <div class="flex items-center space-x-3">
                        <span class="text-xs text-gray-500 font-medium">Status:</span>
                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full 
                            {{ $ticket->status === 'open' ? 'bg-yellow-100 text-yellow-800' : 'bg-green-100 text-green-800' }}">
                            {{ ucfirst($ticket->status) }}
                        </span>
                    </div>
                </div>

                <!-- Ticket Timeline / Body -->
                <div class="p-6 space-y-6">
                    
                    <!-- Message 1 - User Original Request -->
                    <div class="flex items-start space-x-4">
                        <div class="flex-shrink-0 w-10 h-10 bg-indigo-600 text-white rounded-full flex items-center justify-center font-bold">
                            {{ substr($ticket->user->name, 0, 1) }}
                        </div>
                        <div class="flex-1 bg-indigo-50/30 border border-indigo-100 rounded-2xl p-5 relative">
                            <div class="flex justify-between items-center mb-2">
                                <span class="font-bold text-gray-900">{{ $ticket->user->name }}</span>
                                <span class="text-xs text-gray-500">{{ $ticket->created_at->format('M d, Y h:i A') }}</span>
                            </div>
                            <p class="text-gray-700 whitespace-pre-wrap text-sm leading-relaxed">{{ $ticket->message }}</p>

                            <!-- Attachment -->
                            @if($ticket->screenshot_path)
                            <div class="mt-4 pt-4 border-t border-indigo-100" x-data="{ lightbox: false }">
                                <p class="text-xs font-semibold text-indigo-700 uppercase tracking-wider mb-2">Attached Receipt / Screenshot</p>
                                <img src="{{ asset('storage/' . $ticket->screenshot_path) }}" 
                                     alt="Ticket Screenshot" 
                                     @click="lightbox = true"
                                     class="max-w-xs h-32 object-cover rounded-lg border-2 border-white shadow-md cursor-pointer hover:opacity-90 transition-opacity">
                                
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

                    <!-- Message 2 - Admin Reply -->
                    @if($ticket->admin_reply)
                    <div class="flex items-start space-x-4 justify-end">
                        <div class="flex-1 bg-green-50 border border-green-200 rounded-2xl p-5 relative text-right">
                            <div class="flex justify-between items-center mb-2">
                                <span class="text-xs text-gray-500">{{ $ticket->updated_at->format('M d, Y h:i A') }}</span>
                                <span class="font-bold text-green-800">Support Representative</span>
                            </div>
                            <p class="text-gray-700 whitespace-pre-wrap text-sm leading-relaxed text-left">{{ $ticket->admin_reply }}</p>
                        </div>
                        <div class="flex-shrink-0 w-10 h-10 bg-green-600 text-white rounded-full flex items-center justify-center font-bold">
                            A
                        </div>
                    </div>
                    @else
                    <div class="flex items-center justify-center py-6 border-2 border-dashed border-gray-200 rounded-2xl text-gray-400 text-sm">
                        <i class="far fa-hourglass mr-2 animate-pulse"></i>
                        <span>Awaiting response from our support team...</span>
                    </div>
                    @endif

                </div>
            </div>

        </div>
    </div>
</x-app-layout>
