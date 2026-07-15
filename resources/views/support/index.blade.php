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

            <!-- Header -->
            <div class="text-center mb-8">
                <div class="inline-flex items-center justify-center w-16 h-16 bg-indigo-100 rounded-full mb-4 shadow-inner">
                    <i class="fas fa-life-ring text-3xl text-indigo-600"></i>
                </div>
                <h1 class="text-3xl font-bold text-gray-900 mb-2">Customer Support</h1>
                <p class="text-gray-600">Have any questions or encountered issues? Submit a ticket and our support team will help you.</p>
            </div>

            <!-- Single Grid containing Setup & Support Submission -->
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 mb-8" x-data="{ fileName: '' }">
                
                <!-- Left Column - Support Description & Instructions -->
                <div class="lg:col-span-5 bg-white rounded-2xl shadow-md p-6 border border-gray-100 flex flex-col justify-between">
                    <div>
                        <h2 class="text-xl font-bold text-gray-800 mb-4 flex items-center">
                            <span class="w-8 h-8 bg-indigo-100 text-indigo-600 rounded-lg flex items-center justify-center text-sm font-bold mr-2">1</span>
                            Support Center
                        </h2>
                        
                        <div class="space-y-4 text-sm text-gray-600">
                            <p>Our client assistance center operates 24/7. When submitting tickets, please include:</p>
                            <ul class="list-disc list-inside space-y-2 pl-2">
                                <li>A clear and descriptive subject</li>
                                <li>Detailed message explaining your inquiry</li>
                                <li>Optional receipt or screenshot file illustrating the bug or payment</li>
                            </ul>
                            <div class="p-4 bg-indigo-50/50 rounded-xl border border-indigo-100 mt-6">
                                <p class="text-xs text-indigo-800 leading-relaxed font-medium">
                                    <span class="font-bold">Did you know?</span> Many general concerns regarding wallet balances, KYC approvals, or referral allocations can be instantly configured from the dashboard or settings.
                                </p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mt-8 pt-6 border-t border-gray-100 text-xs text-gray-400 text-center">
                        <p>Finovo Support Center • Always happy to help</p>
                    </div>
                </div>

                <!-- Right Column - Submit Ticket Form -->
                <div class="lg:col-span-7 bg-white rounded-2xl shadow-md p-6 border border-gray-100">
                    <h2 class="text-xl font-bold text-gray-800 mb-4 flex items-center">
                        <span class="w-8 h-8 bg-indigo-100 text-indigo-600 rounded-lg flex items-center justify-center text-sm font-bold mr-2">2</span>
                        Open a Support Ticket
                    </h2>

                    <form action="{{ route('support.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                        @csrf
                        
                        <!-- Subject -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Subject <span class="text-red-500">*</span></label>
                            <input type="text" name="subject" required 
                                   class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all" 
                                   placeholder="What do you need help with?" value="{{ old('subject') }}">
                            @error('subject')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Message -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Message / Inquiry <span class="text-red-500">*</span></label>
                            <textarea name="message" rows="4" required
                                      class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all" 
                                      placeholder="Describe your issue or request in detail...">{{ old('message') }}</textarea>
                            @error('message')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Upload Screenshot File -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Attachment / Screenshot <span class="text-gray-400 text-xs">(Optional)</span></label>
                            <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-xl hover:border-indigo-400 transition-colors relative"
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
                                        <label for="screenshot" class="relative cursor-pointer bg-white rounded-md font-semibold text-indigo-600 hover:text-indigo-500">
                                            <span x-text="fileName ? 'Change file' : 'Upload image'"></span>
                                            <input id="screenshot" x-ref="fileInput" name="screenshot" type="file" class="sr-only" accept="image/*"
                                                   @change="fileName = $event.target.files[0] ? $event.target.files[0].name : ''">
                                        </label>
                                        <p class="pl-1" x-show="!fileName">or drag and drop</p>
                                    </div>
                                    <p class="text-xs text-gray-500" x-show="!fileName">PNG, JPG, JPEG up to 5MB</p>
                                    <p class="text-sm font-semibold text-green-600 flex items-center justify-center mt-2" x-show="fileName">
                                        <i class="fas fa-check-circle mr-1"></i> Selected: <span x-text="fileName" class="ml-1 text-gray-700 font-normal truncate max-w-xs"></span>
                                    </p>
                                </div>
                            </div>
                            @error('screenshot')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" class="w-full py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-xl shadow-lg transition-all duration-200 hover:shadow-xl focus:ring-2 focus:ring-indigo-500">
                            <i class="fas fa-paper-plane mr-2"></i> Submit Ticket
                        </button>
                    </form>
                </div>
            </div>

            <!-- Bottom Section - Support Tickets History -->
            <div class="bg-white rounded-2xl shadow-md p-6 border border-gray-100">
                <h2 class="text-xl font-bold text-gray-800 mb-6 flex items-center">
                    <i class="fas fa-history text-indigo-600 mr-2"></i>
                    Your Support Tickets
                </h2>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Created</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Subject</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Message Preview</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Response</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Action</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($tickets as $t)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $t->created_at->format('M d, Y h:i A') }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-900">{{ $t->subject }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ Str::limit($t->message, 30) }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full 
                                        {{ $t->status === 'open' ? 'bg-yellow-100 text-yellow-800' : 'bg-green-100 text-green-800' }}">
                                        {{ ucfirst($t->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                    {!! $t->admin_reply ? '<span class="text-indigo-600 font-semibold"><i class="fas fa-reply mr-1"></i>Replied</span>' : '<span class="text-gray-400">Awaiting Reply</span>' !!}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                    <a href="{{ route('support.show', $t->id) }}" class="text-indigo-600 hover:text-indigo-800 font-semibold flex items-center space-x-1">
                                        <i class="far fa-eye"></i> <span>View</span>
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="px-6 py-8 text-center text-sm text-gray-500">
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
                <div class="mt-4">
                    {{ $tickets->links() }}
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
