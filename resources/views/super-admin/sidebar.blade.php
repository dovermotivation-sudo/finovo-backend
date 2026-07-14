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
