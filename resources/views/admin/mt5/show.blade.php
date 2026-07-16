<x-app-layout>
    <div class="py-8 bg-gray-50 min-h-screen">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Back Button -->
            <a href="{{ route('admin.mt5.index') }}" class="inline-flex items-center text-sm text-gray-500 hover:text-gray-700 mb-6 transition-colors">
                <i class="fas fa-arrow-left mr-2"></i> Back to MT5 Connections
            </a>

            <!-- Success/Error Alert messages -->
            @if(session('success'))
                <div class="mb-6 bg-green-50 border-l-4 border-green-400 p-4 rounded-lg shadow-sm">
                    <div class="flex">
                        <i class="fas fa-check-circle text-green-400 mt-1 mr-3"></i>
                        <p class="text-sm text-green-700 font-medium">{{ session('success') }}</p>
                    </div>
                </div>
            @endif

            @if($errors->any())
                <div class="mb-6 bg-red-50 border-l-4 border-red-400 p-4 rounded-lg shadow-sm">
                    <div class="flex">
                        <i class="fas fa-exclamation-circle text-red-400 mt-1 mr-3"></i>
                        <div class="text-sm text-red-700 font-medium">
                            <ul class="list-disc pl-5">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- User Information Card -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="px-6 py-5 border-b border-gray-100 bg-gray-50/50">
                        <h3 class="text-lg font-semibold text-gray-900">User Information</h3>
                    </div>
                    <div class="p-6">
                        <div class="space-y-4">
                            <div class="flex flex-col">
                                <span class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Full Name</span>
                                <span class="text-base text-gray-900">{{ $user->name }}</span>
                            </div>
                            <div class="flex flex-col">
                                <span class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Email Address</span>
                                <span class="text-base text-gray-900">{{ $user->email }}</span>
                            </div>
                            <div class="flex flex-col">
                                <span class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Phone Number</span>
                                <span class="text-base text-gray-900">{{ $user->phone_number ?? 'Not provided' }}</span>
                            </div>
                            <div class="flex flex-col">
                                <span class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Joined Date</span>
                                <span class="text-base text-gray-900">{{ $user->created_at->format('F d, Y') }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- KYC Documents Card -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="px-6 py-5 border-b border-gray-100 bg-gray-50/50">
                        <h3 class="text-lg font-semibold text-gray-900">KYC Documents</h3>
                    </div>
                    <div class="p-6">
                        @if($user->kycDocuments && $user->kycDocuments->count() > 0)
                            <div class="space-y-4">
                                @foreach($user->kycDocuments as $doc)
                                    <div class="p-4 rounded-xl border {{ $doc->status === 'verified' ? 'border-green-200 bg-green-50' : ($doc->status === 'rejected' ? 'border-red-200 bg-red-50' : 'border-yellow-200 bg-yellow-50') }}">
                                        <div class="flex justify-between items-center mb-2">
                                            <span class="font-semibold text-sm text-gray-900">{{ ucfirst(str_replace('_', ' ', $doc->document_type)) }}</span>
                                            <span class="px-2 py-1 rounded text-xs font-bold uppercase
                                                {{ $doc->status === 'verified' ? 'text-green-700 bg-green-100' : ($doc->status === 'rejected' ? 'text-red-700 bg-red-100' : 'text-yellow-700 bg-yellow-100') }}">
                                                {{ $doc->status }}
                                            </span>
                                        </div>
                                        <div class="flex gap-4">
                                            @if($doc->document_front_path)
                                                <a href="{{ asset('storage/' . $doc->document_front_path) }}" target="_blank" class="text-sm text-blue-600 hover:text-blue-800 flex items-center">
                                                    <i class="fas fa-external-link-alt mr-1"></i> Front
                                                </a>
                                            @endif
                                            @if($doc->document_back_path)
                                                <a href="{{ asset('storage/' . $doc->document_back_path) }}" target="_blank" class="text-sm text-blue-600 hover:text-blue-800 flex items-center">
                                                    <i class="fas fa-external-link-alt mr-1"></i> Back
                                                </a>
                                            @endif
                                            @if($doc->selfie_path)
                                                <a href="{{ asset('storage/' . $doc->selfie_path) }}" target="_blank" class="text-sm text-blue-600 hover:text-blue-800 flex items-center">
                                                    <i class="fas fa-external-link-alt mr-1"></i> Selfie
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-8 text-gray-500">
                                <i class="fas fa-id-card text-4xl mb-3 text-gray-300"></i>
                                <p>No KYC documents submitted yet.</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- MT5 Account Connection Form -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden md:col-span-2">
                    <div class="px-6 py-5 border-b border-gray-100 bg-gray-50/50 flex justify-between items-center">
                        <h3 class="text-lg font-semibold text-gray-900">MT5 Broker Account</h3>
                        @if($user->mt5Account)
                            <span class="px-3 py-1 bg-green-100 text-green-800 text-xs font-bold uppercase rounded-full">Connected</span>
                        @else
                            <span class="px-3 py-1 bg-yellow-100 text-yellow-800 text-xs font-bold uppercase rounded-full">Pending</span>
                        @endif
                    </div>
                    <div class="p-6">
                        <form action="{{ route('admin.mt5.attach', $user->id) }}" method="POST">
                            @csrf
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                                <div>
                                    <label for="login" class="block text-sm font-medium text-gray-700 mb-1">MT5 Login</label>
                                    <input type="text" name="login" id="login" value="{{ old('login', $user->mt5Account->login ?? '') }}" required
                                        class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                </div>
                                <div>
                                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                                    <input type="text" name="password" id="password" value="{{ old('password', $user->mt5Account->password ?? '') }}" required
                                        class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                </div>
                                <div>
                                    <label for="server" class="block text-sm font-medium text-gray-700 mb-1">Server</label>
                                    <input type="text" name="server" id="server" value="{{ old('server', $user->mt5Account->server ?? '') }}" required
                                        class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                </div>
                            </div>
                            <div class="flex justify-end">
                                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-6 rounded-lg transition-colors shadow-sm">
                                    {{ $user->mt5Account ? 'Update Connection' : 'Add Connection' }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
