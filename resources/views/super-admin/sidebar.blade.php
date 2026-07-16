@if(auth()->user()->role === 'super_admin')
<div class="w-64 h-screen bg-gray-900 text-white flex flex-col shadow-lg">
    <!-- Logo / Title -->
    <div class="p-6 text-2xl font-extrabold border-b border-gray-700 flex items-center justify-center">
        Super Admin
    </div>

    <!-- Navigation -->
    <nav class="flex-1 p-4 space-y-3">
        <a href="{{ route('super-admin.users') }}" class="flex items-center px-4 py-3 rounded-lg hover:bg-gray-700 transition-colors duration-200 {{ request()->routeIs('super-admin.users') ? 'bg-gray-700' : '' }}">
            <!-- Icon -->
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
            </svg>
            All Users
        </a>

        <a href="{{ route('admin.deposits.index') }}" class="flex items-center px-4 py-3 rounded-lg hover:bg-gray-700 transition-colors duration-200 {{ request()->routeIs('admin.deposits.index') || request()->routeIs('admin.deposits.show') ? 'bg-gray-700' : '' }}">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
            </svg>
            Deposits List
        </a>

        <a href="{{ route('admin.withdrawals.index') }}" class="flex items-center px-4 py-3 rounded-lg hover:bg-gray-700 transition-colors duration-200 {{ request()->routeIs('admin.withdrawals.index') || request()->routeIs('admin.withdrawals.show') ? 'bg-gray-700' : '' }}">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2" />
            </svg>
            Withdrawals List
        </a>

        <a href="{{ route('admin.deposits.settings') }}" class="flex items-center px-4 py-3 rounded-lg hover:bg-gray-700 transition-colors duration-200 {{ request()->routeIs('admin.deposits.settings') ? 'bg-gray-700' : '' }}">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
            </svg>
            Deposit Settings
        </a>

        <a href="{{ route('admin.support.index') }}" class="flex items-center px-4 py-3 rounded-lg hover:bg-gray-700 transition-colors duration-200 {{ request()->routeIs('admin.support.*') ? 'bg-gray-700' : '' }}">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z" />
            </svg>
            Support Tickets
        </a>

        <!-- Uncomment if needed -->
        <!--
        <a href="{{ route('super-admin.plans') }}" class="flex items-center px-4 py-3 rounded-lg hover:bg-gray-700 transition-colors duration-200 {{ request()->routeIs('super-admin.plans') ? 'bg-gray-700' : '' }}">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2" />
            </svg>
            Edit Plans
        </a>
        -->

        <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="flex items-center px-4 py-3 rounded-lg hover:bg-gray-700 transition-colors duration-200">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7" />
            </svg>
            Logout
        </a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
            @csrf
        </form>
    </nav>

    <!-- Footer or extra content -->
    <div class="p-4 border-t border-gray-700 text-sm text-gray-400 text-center">
        © {{ date('Y') }} Your Company
    </div>
</div>
@endif
