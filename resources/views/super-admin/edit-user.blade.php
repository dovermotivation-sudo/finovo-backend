<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('dashboard.Edit User') }}
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 mt-6">
            
            <!-- Update User -->
            <div class="lg:col-span-12 max-w-3xl mx-auto w-full bg-white rounded-2xl shadow-lg p-6">
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
