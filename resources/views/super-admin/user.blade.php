<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('dashboard.All Users') }}
        </h2>
    </x-slot>
<div class="max-w-7xl mx-auto px-4 mt-6">

    @if(session('success'))
        <div class="bg-green-100 text-green-800 p-4 rounded-lg mb-6 shadow-sm">
            {{ session('success') }}
        </div>
    @endif

    <div class="overflow-x-auto bg-white rounded-2xl shadow-md">
        <form id="deleteForm" action="{{ route('super-admin.users.delete') }}" method="POST">
            @csrf
            @method('DELETE')
            
            <div class="p-4 border-b border-gray-200 flex justify-between items-center">
                <div class="flex items-center space-x-4">
                    <input type="checkbox" id="selectAll" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500">
                    <label for="selectAll" class="text-sm font-medium text-gray-700">{{ __('users.select_all') }}</label>
                </div>
                <button type="button" id="deleteBtn" class="px-4 py-2 bg-red-600 text-white text-sm font-medium rounded-lg shadow hover:bg-red-700 transition-colors disabled:bg-gray-400 disabled:cursor-not-allowed" disabled>
                    {{ __('users.delete_selected') }}
                </button>
            </div>

            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">{{ __('users.select') }}</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">{{ __('users.full_name') }}</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">{{ __('users.email') }}</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">{{ __('users.portfolio_value') }}</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">{{ __('users.total_returns') }}</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">{{ __('users.growth_rate') }}</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">{{ __('users.actions') }}</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($users as $user)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <input type="checkbox" name="users[]" value="{{ $user->id }}" class="user-checkbox w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500">
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-gray-700 font-medium">{{ $user->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-gray-600">{{ $user->email }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-gray-700">₹{{ number_format($user->portfolio_value, 2) }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-gray-700">₹{{ number_format($user->total_returns, 2) }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-gray-700">{{ $user->growth_rate }}%</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <a href="{{ route('super-admin.users.edit', $user->id) }}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg shadow hover:bg-blue-700 transition-colors">
                                    {{ __('users.edit') }}
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-6 py-8 text-center text-gray-500">{{ __('users.no_users_found') }}</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const selectAllCheckbox = document.getElementById('selectAll');
    const userCheckboxes = document.querySelectorAll('.user-checkbox');
    const deleteBtn = document.getElementById('deleteBtn');
    const deleteForm = document.getElementById('deleteForm');

    function updateDeleteButton() {
        const checkedBoxes = document.querySelectorAll('.user-checkbox:checked');
        deleteBtn.disabled = checkedBoxes.length === 0;
    }

    selectAllCheckbox.addEventListener('change', function() {
        userCheckboxes.forEach(checkbox => {
            checkbox.checked = this.checked;
        });
        updateDeleteButton();
    });

    userCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            const allChecked = Array.from(userCheckboxes).every(cb => cb.checked);
            const someChecked = Array.from(userCheckboxes).some(cb => cb.checked);
            
            selectAllCheckbox.checked = allChecked;
            selectAllCheckbox.indeterminate = someChecked && !allChecked;
            
            updateDeleteButton();
        });
    });

    deleteBtn.addEventListener('click', function() {
        const checkedBoxes = document.querySelectorAll('.user-checkbox:checked');
        const count = checkedBoxes.length;
        
        if (count === 0) {
            return;
        }

        if (confirm(`Are you sure you want to delete ${count} user(s)? This action cannot be undone.`)) {
            deleteForm.submit();
        }
    });
});
</script>
</x-app-layout>
