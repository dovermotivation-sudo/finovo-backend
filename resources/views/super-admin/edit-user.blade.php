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

            <!-- Daily Returns Management -->
            <div class="lg:col-span-12 max-w-3xl mx-auto w-full bg-white rounded-2xl shadow-lg p-6">
                <div class="flex items-center justify-between mb-5">
                    <div>
                        <h2 class="text-xl font-semibold text-gray-700">Daily Returns</h2>
                        <p class="text-sm text-gray-400 mt-0.5">Set the daily return % for each of the last 7 days</p>
                    </div>
                    <span class="px-3 py-1 bg-blue-50 text-blue-700 rounded-full text-xs font-semibold">Last 7 Days</span>
                </div>

                @if(session('daily_returns_success'))
                    <div class="mb-4 bg-green-50 border-l-4 border-green-400 p-3 rounded-lg text-sm text-green-700 font-medium">
                        {{ session('daily_returns_success') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('super-admin.users.daily-returns.update', $user->id) }}" class="space-y-3">
                    @csrf
                    @php
                        $today   = \Carbon\Carbon::today();
                        $existing = $user->dailyReturns()
                            ->whereBetween('return_date', [$today->copy()->subDays(6), $today])
                            ->get()
                            ->keyBy(fn($r) => $r->return_date->format('Y-m-d'));
                    @endphp

                    @for ($i = 6; $i >= 0; $i--)
                        @php
                            $date    = $today->copy()->subDays($i);
                            $key     = $date->format('Y-m-d');
                            $record  = $existing[$key] ?? null;
                            $pct     = $record ? $record->return_percentage : '';
                            $note    = $record ? $record->notes : '';
                            $isToday = $i === 0;
                        @endphp
                        <div class="grid grid-cols-12 gap-3 items-center p-3 rounded-xl {{ $isToday ? 'bg-indigo-50 border border-indigo-200' : 'bg-gray-50' }}">
                            <div class="col-span-3">
                                <p class="text-sm font-semibold text-gray-700">{{ $date->format('D') }}</p>
                                <p class="text-xs text-gray-400">{{ $date->format('d M Y') }}{{ $isToday ? ' (Today)' : '' }}</p>
                                <input type="hidden" name="dates[]" value="{{ $key }}">
                            </div>
                            <div class="col-span-4">
                                <label class="block text-xs text-gray-500 mb-1">Return %</label>
                                <div class="relative">
                                    <input
                                        type="number"
                                        step="0.0001"
                                        name="percentages[]"
                                        value="{{ $pct }}"
                                        placeholder="0.0000"
                                        class="w-full pr-6 p-2 text-sm border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-400"
                                    >
                                    <span class="absolute right-2 top-1/2 -translate-y-1/2 text-gray-400 text-xs">%</span>
                                </div>
                            </div>
                            <div class="col-span-5">
                                <label class="block text-xs text-gray-500 mb-1">Note (optional)</label>
                                <input
                                    type="text"
                                    name="notes[]"
                                    value="{{ $note }}"
                                    placeholder="e.g. Market rally"
                                    class="w-full p-2 text-sm border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-400"
                                >
                            </div>
                        </div>
                    @endfor

                    <div class="flex justify-end mt-4">
                        <button type="submit" class="bg-indigo-600 text-white px-6 py-3 rounded-lg font-semibold shadow hover:bg-indigo-700 transition-colors flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            Save Daily Returns
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</x-app-layout>
