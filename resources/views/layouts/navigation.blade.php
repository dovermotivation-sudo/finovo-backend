<!-- Two-Level Navigation System -->
<div x-data="{ open: false }">
    <!-- Top Header with Logo, Language, and Profile -->
    <header class="bg-indigo-700 text-white shadow-lg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center py-4">
                <!-- Logo -->
                <div class="flex items-center space-x-3">
                    <div class="bg-white rounded-lg p-2">
                        <a href="{{ Auth::user()->role === 'super_admin' ? route('super-admin.dashboard') : route('user.dashboard') }}" class="flex items-center">
                            <img src="{{ asset('logo/finovo-logo.png') }}" alt="Finovo Logo" class="h-8 w-auto">
                        </a>
                    </div>
                </div>
                
                <!-- Right side -->
                <div class="flex items-center space-x-4">
                    <!-- Language Dropdown -->
                    <div class="relative">
                        <button id="languageDropdown" class="flex items-center space-x-2 bg-white bg-opacity-20 rounded-lg px-3 py-2 hover:bg-opacity-30 transition-colors">
                            <img src="https://flagcdn.com/w20/gb.png" alt="EN" class="w-5 h-3">
                            <span class="text-sm font-medium">EN</span>
                            <i class="fas fa-chevron-down text-xs"></i>
                        </button>
                        
                        <!-- Dropdown Menu -->
                        <div id="languageMenu" class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-gray-200 hidden z-50">
                            <div class="py-2">
                                <a href="#" class="language-option flex items-center space-x-3 px-4 py-2 hover:bg-gray-100 transition-colors" data-lang="en" data-flag="https://flagcdn.com/w20/gb.png" data-text="English">
                                    <img src="https://flagcdn.com/w20/gb.png" alt="English" class="w-5 h-3">
                                    <span class="text-gray-700">English</span>
                                    <i class="fas fa-check text-blue-600 ml-auto language-check"></i>
                                </a>
                                <a href="#" class="language-option flex items-center space-x-3 px-4 py-2 hover:bg-gray-100 transition-colors" data-lang="es" data-flag="https://flagcdn.com/w20/es.png" data-text="Español">
                                    <img src="https://flagcdn.com/w20/es.png" alt="Spanish" class="w-5 h-3">
                                    <span class="text-gray-700">Español</span>
                                    <i class="fas fa-check text-blue-600 ml-auto language-check hidden"></i>
                                </a>
                                <a href="#" class="language-option flex items-center space-x-3 px-4 py-2 hover:bg-gray-100 transition-colors" data-lang="fr" data-flag="https://flagcdn.com/w20/fr.png" data-text="Français">
                                    <img src="https://flagcdn.com/w20/fr.png" alt="French" class="w-5 h-3">
                                    <span class="text-gray-700">Français</span>
                                    <i class="fas fa-check text-blue-600 ml-auto language-check hidden"></i>
                                </a>
                                <a href="#" class="language-option flex items-center space-x-3 px-4 py-2 hover:bg-gray-100 transition-colors" data-lang="hi" data-flag="https://flagcdn.com/w20/in.png" data-text="Hindi">
                                    <img src="https://flagcdn.com/w20/in.png" alt="Hindi" class="w-5 h-3">
                                    <span class="text-gray-700">Hindi</span>
                                    <i class="fas fa-check text-blue-600 ml-auto language-check hidden"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Other Icons -->
                    <div class="flex items-center space-x-3">
                        <i class="fas fa-bell text-lg hover:text-blue-200 cursor-pointer transition-colors"></i>
                        <i class="fas fa-cog text-lg hover:text-blue-200 cursor-pointer transition-colors"></i>
                        <i class="fas fa-chart-bar text-lg hover:text-blue-200 cursor-pointer transition-colors"></i>
                    </div>
                    
                    <!-- User Profile -->
                    <div class="relative">
                        <x-dropdown align="right" width="64">
                            <x-slot name="trigger">
                                <button class="flex items-center space-x-2 bg-white bg-opacity-20 rounded-full px-3 py-2 hover:bg-opacity-30 transition-colors">
                                    @if(Auth::user()->profile_image_url)
                                        <img src="{{ Auth::user()->profile_image_url }}" alt="Profile" class="w-8 h-8 rounded-full object-cover border-2 border-white">
                                    @else
                                        <div class="w-8 h-8 bg-blue-500 rounded-full flex items-center justify-center">
                                            <span class="text-sm font-semibold">{{ Auth::user()->initials }}</span>
                                        </div>
                                    @endif
                                    <span class="text-sm">{{ Auth::user()->name }}</span>
                                    <i class="fas fa-chevron-down text-xs"></i>
                                </button>
                            </x-slot>

                            <x-slot name="content">
                                <!-- User Info Section -->
                                <div class="px-4 py-3 border-b border-gray-200">
                                    <div class="flex items-center space-x-3">
                                        @if(Auth::user()->profile_image_url)
                                            <img src="{{ Auth::user()->profile_image_url }}" alt="Profile" class="w-10 h-10 rounded-full object-cover border-2 border-gray-200">
                                        @else
                                            <div class="w-10 h-10 bg-blue-500 rounded-full flex items-center justify-center">
                                                <span class="text-white font-semibold">{{ Auth::user()->initials }}</span>
                                            </div>
                                        @endif
                                        <div>
                                            <p class="font-semibold text-gray-900">{{ Auth::user()->name }}</p>
                                            <p class="text-sm text-gray-500">{{ Auth::user()->email }}</p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Account Balance Section -->
                                <div class="px-4 py-3 border-b border-gray-200 bg-gray-50">
                                    <p class="text-xs text-gray-500 uppercase tracking-wide font-semibold mb-1">{{ __('profile.account_balance') }}</p>
                                    <p class="text-lg font-bold text-gray-900">0.00 USD</p>
                                    <!-- <button class="mt-2 bg-blue-600 text-white px-3 py-1 rounded text-sm hover:bg-blue-700 transition-colors">
                                        {{ __('profile.withdraw_balance') }}
                                    </button> -->
                                </div>

                                <!-- Menu Items -->
                                <div class="py-1">
                                    <x-dropdown-link :href="route('profile.edit')" class="flex items-center space-x-2">
                                        <i class="fas fa-user w-4"></i>
                                        <span>{{ __('profile.my_profile') }}</span>
                                    </x-dropdown-link>

                                    <x-dropdown-link :href="route('deposits.index')" class="flex items-center space-x-2">
                                        <i class="fas fa-wallet w-4 text-blue-500"></i>
                                        <span class="font-semibold text-blue-600">{{ __('profile.deposit_funds') }}</span>
                                    </x-dropdown-link>
                                    
                                    <x-dropdown-link href="#" class="flex items-center space-x-2">
                                        <i class="fas fa-chart-line w-4"></i>
                                        <span>{{ __('profile.activity') }}</span>
                                    </x-dropdown-link>
                                    
                                    <x-dropdown-link href="#" class="flex items-center space-x-2">
                                        <i class="fas fa-newspaper w-4"></i>
                                        <span>{{ __('profile.news') }}</span>
                                    </x-dropdown-link>
                                    
                                    <x-dropdown-link :href="route('support.index')" class="flex items-center space-x-2">
                                        <i class="fas fa-life-ring w-4"></i>
                                        <span>{{ __('profile.support') }}</span>
                                    </x-dropdown-link>
                                    
                                    <x-dropdown-link href="#" class="flex items-center space-x-2">
                                        <i class="fas fa-graduation-cap w-4"></i>
                                        <span>{{ __('profile.tutorials') }}</span>
                                    </x-dropdown-link>
                                </div>

                                <!-- Logout Section -->
                                <div class="border-t border-gray-200">
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <x-dropdown-link :href="route('logout')"
                                                onclick="event.preventDefault();
                                                            this.closest('form').submit();"
                                                class="flex items-center space-x-2 text-red-600 hover:text-red-700 hover:bg-red-50">
                                            <i class="fas fa-sign-out-alt w-4"></i>
                                            <span>{{ __('profile.logout') }}</span>
                                        </x-dropdown-link>
                                    </form>
                                </div>
                            </x-slot>
                        </x-dropdown>
                    </div>
                    
                    <!-- Mobile menu button -->
                    <div class="sm:hidden">
                        <button @click="open = ! open" class="text-white hover:text-blue-200 transition-colors">
                            <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                                <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Secondary Navigation Bar for Menu Items -->
    <nav class="bg-white border-b border-gray-200 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex space-x-8">
                <!-- Dashboard Link -->
                <a href="{{ Auth::user()->role === 'super_admin' ? route('super-admin.dashboard') : route('user.dashboard') }}" 
                   class="border-b-2 {{ request()->routeIs(Auth::user()->role === 'super_admin' ? 'super-admin.dashboard' : 'user.dashboard') ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} py-4 px-1 text-sm font-medium flex items-center space-x-2 transition-colors">
                    <i class="fas fa-chart-line"></i>
                    <span>{{ __('dashboard.Dashboard') }}</span>
                </a>
                
                <!-- User Dashboard Link (For regular users) -->
                @if(Auth::user()->role !== 'super_admin')
                <!-- <a href="{{ route('dashboard') }}" 
                   class="border-b-2 {{ request()->routeIs('dashboard') ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} py-4 px-1 text-sm font-medium flex items-center space-x-2 transition-colors">
                    <i class="fas fa-user-circle"></i>
                    <span>User Dashboard</span>
                </a> -->
                
                <!-- Crypto Link -->
                <a href="{{ route('crypto') }}" 
                   class="border-b-2 {{ request()->routeIs('crypto') ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} py-4 px-1 text-sm font-medium flex items-center space-x-2 transition-colors">
                    <i class="fab fa-bitcoin"></i>
                    <span>Crypto</span>
                </a>
                
                <!-- Derivative Link -->
                <a href="{{ route('derivative') }}" 
                   class="border-b-2 {{ request()->routeIs('derivative') ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} py-4 px-1 text-sm font-medium flex items-center space-x-2 transition-colors">
                    <i class="fas fa-chart-area"></i>
                    <span>Derivative</span>
                </a>
                
                <!-- Fix Flex Link -->
                <a href="{{ route('fix-flex') }}" 
                   class="border-b-2 {{ request()->routeIs('fix-flex') ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} py-4 px-1 text-sm font-medium flex items-center space-x-2 transition-colors">
                    <i class="fas fa-coins"></i>
                    <span>Fix Flex</span>
                </a>
                
                <!-- Compare Link -->
                <a href="{{ route('compare') }}" 
                   class="border-b-2 {{ request()->routeIs('compare') ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} py-4 px-1 text-sm font-medium flex items-center space-x-2 transition-colors">
                    <i class="fas fa-balance-scale"></i>
                    <span>Compare</span>
                </a>
                
                <!-- Referrals Link -->
                <a href="{{ route('referrals.index') }}" 
                   class="border-b-2 {{ request()->routeIs('referrals.*') ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} py-4 px-1 text-sm font-medium flex items-center space-x-2 transition-colors">
                    <i class="fas fa-gift"></i>
                    <span>Referrals</span>
                </a>
                
                <!-- KYC Application Link -->
                <div class="ml-auto">
                    <a href="{{ route('kyc.application') }}" 
                       class="border-b-2 {{ request()->routeIs('kyc.application') ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} py-4 px-1 text-sm font-medium flex items-center space-x-2 transition-colors">
                        <i class="fas fa-user-check"></i>
                        <span>KYC Application</span>
                    </a>
                </div>
                @endif
                
                <!-- Users Link (Super Admin Only) -->
                @if(Auth::user()->role === 'super_admin')
                <a href="{{ route('super-admin.users') }}" 
                   class="border-b-2 {{ request()->routeIs('super-admin.users') ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} py-4 px-1 text-sm font-medium flex items-center space-x-2 transition-colors">
                    <i class="fas fa-users"></i>
                    <span>{{ __('dashboard.Users') }}</span>
                </a>
                
                <!-- KYC Management Link (Super Admin Only) -->
                <a href="{{ route('admin.kyc.index') }}" 
                   class="border-b-2 {{ request()->routeIs('admin.kyc.*') ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} py-4 px-1 text-sm font-medium flex items-center space-x-2 transition-colors">
                    <i class="fas fa-id-card"></i>
                    <span>KYC Management</span>
                </a>
                
                <!-- Referrals Management Link (Super Admin Only) -->
                <a href="{{ route('admin.referrals.index') }}" 
                   class="border-b-2 {{ request()->routeIs('admin.referrals.*') ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} py-4 px-1 text-sm font-medium flex items-center space-x-2 transition-colors">
                    <i class="fas fa-gift"></i>
                    <span>Referrals</span>
                </a>

                <!-- Deposits Management Link (Super Admin Only) -->
                <a href="{{ route('admin.deposits.index') }}" 
                   class="border-b-2 {{ request()->routeIs('admin.deposits.*') && !request()->routeIs('admin.deposits.settings') ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} py-4 px-1 text-sm font-medium flex items-center space-x-2 transition-colors">
                    <i class="fas fa-wallet"></i>
                    <span>Deposit Management</span>
                </a>

                <!-- Deposit Settings Link (Super Admin Only) -->
                <a href="{{ route('admin.deposits.settings') }}" 
                   class="border-b-2 {{ request()->routeIs('admin.deposits.settings') ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} py-4 px-1 text-sm font-medium flex items-center space-x-2 transition-colors">
                    <i class="fas fa-cog"></i>
                    <span>Deposit Settings</span>
                </a>

                <!-- Support Management Link (Super Admin Only) -->
                <a href="{{ route('admin.support.index') }}" 
                   class="border-b-2 {{ request()->routeIs('admin.support.*') ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} py-4 px-1 text-sm font-medium flex items-center space-x-2 transition-colors">
                    <i class="fas fa-life-ring"></i>
                    <span>Support Management</span>
                </a>
                @endif
            </div>
        </div>
    </nav>

    <!-- Mobile Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden bg-white border-b border-gray-200">
        <div class="pt-2 pb-3 space-y-1">
            <a href="{{ Auth::user()->role === 'super_admin' ? route('super-admin.dashboard') : route('user.dashboard') }}" 
               class="block pl-3 pr-4 py-2 border-l-4 {{ request()->routeIs(Auth::user()->role === 'super_admin' ? 'super-admin.dashboard' : 'user.dashboard') ? 'border-blue-400 text-blue-700 bg-blue-50' : 'border-transparent text-gray-600 hover:text-gray-800 hover:bg-gray-50 hover:border-gray-300' }} text-base font-medium transition-colors">
                <i class="fas fa-chart-line mr-2"></i>{{ __('dashboard.Dashboard') }}
            </a>
            
            @if(Auth::user()->role !== 'super_admin')
            <a href="{{ route('dashboard') }}" 
               class="block pl-3 pr-4 py-2 border-l-4 {{ request()->routeIs('dashboard') ? 'border-blue-400 text-blue-700 bg-blue-50' : 'border-transparent text-gray-600 hover:text-gray-800 hover:bg-gray-50 hover:border-gray-300' }} text-base font-medium transition-colors">
                <i class="fas fa-user-circle mr-2"></i>User Dashboard
            </a>
            
            <a href="{{ route('crypto') }}" 
               class="block pl-3 pr-4 py-2 border-l-4 {{ request()->routeIs('crypto') ? 'border-blue-400 text-blue-700 bg-blue-50' : 'border-transparent text-gray-600 hover:text-gray-800 hover:bg-gray-50 hover:border-gray-300' }} text-base font-medium transition-colors">
                <i class="fab fa-bitcoin mr-2"></i>Crypto
            </a>
            
            <a href="{{ route('derivative') }}" 
               class="block pl-3 pr-4 py-2 border-l-4 {{ request()->routeIs('derivative') ? 'border-blue-400 text-blue-700 bg-blue-50' : 'border-transparent text-gray-600 hover:text-gray-800 hover:bg-gray-50 hover:border-gray-300' }} text-base font-medium transition-colors">
                <i class="fas fa-chart-area mr-2"></i>Derivative
            </a>
            
            <a href="{{ route('fix-flex') }}" 
               class="block pl-3 pr-4 py-2 border-l-4 {{ request()->routeIs('fix-flex') ? 'border-blue-400 text-blue-700 bg-blue-50' : 'border-transparent text-gray-600 hover:text-gray-800 hover:bg-gray-50 hover:border-gray-300' }} text-base font-medium transition-colors">
                <i class="fas fa-coins mr-2"></i>Fix Flex
            </a>
            
            <a href="{{ route('compare') }}" 
               class="block pl-3 pr-4 py-2 border-l-4 {{ request()->routeIs('compare') ? 'border-blue-400 text-blue-700 bg-blue-50' : 'border-transparent text-gray-600 hover:text-gray-800 hover:bg-gray-50 hover:border-gray-300' }} text-base font-medium transition-colors">
                <i class="fas fa-balance-scale mr-2"></i>Compare
            </a>
            
            <a href="{{ route('referrals.index') }}" 
               class="block pl-3 pr-4 py-2 border-l-4 {{ request()->routeIs('referrals.*') ? 'border-blue-400 text-blue-700 bg-blue-50' : 'border-transparent text-gray-600 hover:text-gray-800 hover:bg-gray-50 hover:border-gray-300' }} text-base font-medium transition-colors">
                <i class="fas fa-gift mr-2"></i>Referrals
            </a>
            
            <a href="{{ route('kyc.application') }}" 
               class="block pl-3 pr-4 py-2 border-l-4 {{ request()->routeIs('kyc.application') ? 'border-blue-400 text-blue-700 bg-blue-50' : 'border-transparent text-gray-600 hover:text-gray-800 hover:bg-gray-50 hover:border-gray-300' }} text-base font-medium transition-colors">
                <i class="fas fa-user-check mr-2"></i>KYC Application
            </a>
            @endif
            
            @if(Auth::user()->role === 'super_admin')
            <a href="{{ route('super-admin.users') }}" 
               class="block pl-3 pr-4 py-2 border-l-4 {{ request()->routeIs('super-admin.users') ? 'border-blue-400 text-blue-700 bg-blue-50' : 'border-transparent text-gray-600 hover:text-gray-800 hover:bg-gray-50 hover:border-gray-300' }} text-base font-medium transition-colors">
                <i class="fas fa-users mr-2"></i>{{ __('dashboard.Users') }}
            </a>
            @endif
        </div>
    </div>
</div>
