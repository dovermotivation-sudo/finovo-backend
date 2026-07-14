<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('dashboard.Edit User') }}
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 mt-6">
            
            <!-- Left Column: Plan Details -->
            <div class="lg:col-span-6 bg-white rounded-2xl shadow-lg p-6">
                <h2 class="text-xl font-semibold mb-4 text-gray-700">{{ __('users.plan_information') }}</h2>
                @if($user->plan)
                    <div class="space-y-3 max-h-[80vh] overflow-y-auto">
                        
                        <div class="p-3 bg-gray-50 rounded-lg">
                            <p class="text-sm font-medium text-gray-600">{{ __('users.plan_type') }}</p>
                            <p class="text-gray-800">{{ $user->plan->plan_type }}</p>
                        </div>
                        <div class="p-3 bg-gray-50 rounded-lg">
                            <p class="text-sm font-medium text-gray-600">{{ __('users.name') }}</p>
                            <p class="text-gray-800">{{ $user->plan->name }}</p>
                        </div>
                        <div class="p-3 bg-gray-50 rounded-lg">
                            <p class="text-sm font-medium text-gray-600">{{ __('users.description') }}</p>
                            <p class="text-gray-800">{{ $user->plan->description }}</p>
                        </div>
                        <div class="p-3 bg-gray-50 rounded-lg">
                            <p class="text-sm font-medium text-gray-600">{{ __('users.roi') }}</p>
                            <p class="text-gray-800">{{ $user->plan->roi }}</p>
                        </div>
                        <div class="p-3 bg-gray-50 rounded-lg">
                            <p class="text-sm font-medium text-gray-600">{{ __('users.minimum_investment') }}</p>
                            <p class="text-gray-800">{{ $user->plan->minimum_investment }}</p>
                        </div>
                        <div class="p-3 bg-gray-50 rounded-lg">
                            <p class="text-sm font-medium text-gray-600">{{ __('users.risk_level') }}</p>
                            <p class="text-gray-800">{{ $user->plan->risk_level }}</p>
                        </div>
                        <div class="p-3 bg-gray-50 rounded-lg">
                            <p class="text-sm font-medium text-gray-600">{{ __('users.report_frequency') }}</p>
                            <p class="text-gray-800">{{ $user->plan->report_frequency }}</p>
                        </div>
                        <div class="p-3 bg-gray-50 rounded-lg">
                            <p class="text-sm font-medium text-gray-600">{{ __('users.support_type') }}</p>
                            <p class="text-gray-800">{{ $user->plan->support_type }}</p>
                        </div>
                        <div class="p-3 bg-gray-50 rounded-lg">
                            <p class="text-sm font-medium text-gray-600">{{ __('users.activation_time') }}</p>
                            <p class="text-gray-800">{{ $user->plan->activation_time ?? '-' }}</p>
                        </div>
                        <div class="p-3 bg-gray-50 rounded-lg">
                            <p class="text-sm font-medium text-gray-600">{{ __('users.other_features') }}</p>
                            @php
                                $features = json_decode($user->plan->other_features, true);
                            @endphp
                            @if($features)
                                <ul class="list-disc list-inside text-gray-800">
                                    @foreach($features['features'] as $key => $value)
                                        <li>{{ $key }}: {{ is_bool($value) ? ($value ? __('users.yes') : __('users.no')) : $value }}</li>
                                    @endforeach
                                </ul>
                            @else
                                <p class="text-gray-500">{{ __('users.no_additional_features') }}</p>
                            @endif
                        </div>
                        <div class="p-3 bg-gray-50 rounded-lg">
                            <p class="text-sm font-medium text-gray-600">{{ __('users.added_on') }}</p>
                            <p class="text-gray-800">{{ $user->plan->created_at->format('M d, Y') }}</p>
                        </div>
                    </div>
                @else
                    <div class="p-3 bg-gray-100 rounded-lg text-gray-500">{{ __('users.no_plan_assigned') }}</div>
                @endif
            </div>

            <!-- Right Column: Update User -->
            <div class="lg:col-span-6 bg-white rounded-2xl shadow-lg p-6">
                <h2 class="text-xl font-semibold mb-4 text-gray-700">{{ __('users.update_user_information') }}</h2>
                <form method="POST" action="{{ route('super-admin.users.update', $user->id) }}" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block mb-1 font-medium text-gray-600">{{ __('users.full_name') }}</label>
                        <input type="text" name="name" value="{{ old('name', $user->name) }}" class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-400" required>
                    </div>
                    <div>
                        <label class="block mb-1 font-medium text-gray-600">{{ __('users.email') }}</label>
                        <div class="w-full p-3 bg-gray-100 rounded-lg text-gray-700 border border-gray-200">
                            {{ $user->email }}
                        </div>
                    </div>
                    <div>
                        <label class="block mb-1 font-medium text-gray-600">{{ __('users.portfolio_value') }}</label>
                        <input type="number" step="0.01" name="portfolio_value" value="{{ old('portfolio_value', $user->portfolio_value) }}" class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-400" required>
                    </div>
                    <div>
                        <label class="block mb-1 font-medium text-gray-600">{{ __('users.growth_rate_percent') }}</label>
                        <input type="number" step="0.01" name="total_returns" value="{{ old('total_returns', $user->total_returns) }}" class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-400" required>
                    </div>
                    <div>
                        <label class="block mb-1 font-medium text-gray-600">{{ __('users.total_returns') }}</label>
                        <input type="number" step="0.01" name="growth_rate" value="{{ old('growth_rate', $user->growth_rate) }}" class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-400" required>
                    </div>
                    <div class="flex justify-end mt-4">
                        <button type="submit" class="bg-indigo-600 text-white px-6 py-3 rounded-lg font-semibold shadow hover:bg-indigo-700 transition-colors">
                            {{ __('users.update_user') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
