<div class="max-w-4xl mx-auto py-6 sm:px-6 lg:px-8">
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
         
            <h2 class="text-2xl font-bold text-gray-800 mb-6">{{ __('profile.profile_information') }}</h2>
            
            <form method="post" action="{{ route('profile.update') }}" class="space-y-6" enctype="multipart/form-data">
                @csrf
                @method('patch')
                
                <!-- Profile Image Upload -->
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-3">{{ __('profile.profile_picture') }}</label>
                    <div class="flex items-center space-x-6">
                        <!-- Current Profile Image -->
                        <div class="flex-shrink-0">
                            
                            @if($user->profile_image_url)
                                <img id="current-avatar" src="{{ $user->profile_image_url }}" alt="Profile" class="w-20 h-20 rounded-full object-cover border-4 border-gray-200">
                            @else
                                <div id="current-avatar" class="w-20 h-20 bg-blue-500 rounded-full flex items-center justify-center text-white text-2xl font-bold border-4 border-gray-200">
                                    {{ $user->initials }}
                                </div>
                            @endif
                        </div>
                        
                        <!-- Upload Controls -->
                        <div class="flex-1">
                            <div class="flex items-center space-x-4">
                                <label for="profile_image" class="cursor-pointer bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition-colors">
                                    <i class="fas fa-camera mr-2"></i>
                                    {{ __('profile.choose_photo') }}
                                </label>
                                <input type="file" 
                                       id="profile_image" 
                                       name="profile_image" 
                                       accept="image/jpeg,image/png,image/jpg,image/gif"
                                       class="hidden"
                                       onchange="previewImage(this)">
                                       
                                @if($user->profile_image)
                                    <!-- <button type="button" 
                                            onclick="removeProfileImage()" 
                                            class="text-red-600 hover:text-red-800 text-sm font-medium">
                                        {{ __('profile.remove_photo') }}
                                    </button>
                                    <input type="hidden" id="remove_image" name="remove_image" value="0"> -->
                                @endif
                            </div>
                            <p class="text-xs text-gray-500 mt-2">
                                {{ __('profile.image_requirements') }}
                            </p>
                        </div>
                    </div>
                    @error('profile_image')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Name Field -->
                <div class="mb-6">
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">{{ __('profile.name') }}</label>
                    <div class="relative rounded-md shadow-sm">
                        <input type="text" 
                               id="name" 
                               name="name" 
                               value="{{ old('name', $user->name) }}" 
                               required 
                               autofocus 
                               autocomplete="name"
                               class="block w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        >
                    </div>
                    @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Email Field (Read-only) -->
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('profile.email') }}</label>
                    <div class="relative">
                        <div class="block w-full px-4 py-2 bg-gray-100 border border-gray-300 rounded-md">
                            {{ $user->email }}
                        </div>
                    </div>
                    @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                        <div class="mt-2">
                            <p class="text-sm text-gray-600">
                                {{ __('profile.email_unverified') }}
                                <form id="send-verification" method="post" action="{{ route('verification.send') }}" class="inline">
                                    @csrf
                                    <button type="submit" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                        {{ __('profile.resend_verification') }}
                                    </button>
                                </form>
                            </p>
                            @if (session('status') === 'verification-link-sent')
                                <p class="mt-2 text-sm font-medium text-green-600">
                                    {{ __('profile.verification_sent') }}
                                </p>
                            @endif
                        </div>
                    @endif
                </div>
                
               <!-- Phone Number Field -->
                <div class="mb-6">
                    <label for="phone_number" class="block text-sm font-medium text-gray-700 mb-1">
                        {{ __('profile.phone_number') }}
                    </label>
                    <div class="relative rounded-md shadow-sm">
                        <!-- Phone Icon -->
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M2 3.5A1.5 1.5 0 013.5 2h1.148a1.5 1.5 0 011.465 1.175l.716 3.223a1.5 1.5 0 01-1.052 1.767l-.933.267c-.41.117-.643.555-.48.95a11.542 11.542 0 006.254 6.254c.395.163.833-.07.95-.48l.267-.933a1.5 1.5 0 011.767-1.052l3.223.716A1.5 1.5 0 0118 15.352V16.5a1.5 1.5 0 01-1.5 1.5H15c-1.149 0-2.263-.15-3.326-.43A13.022 13.022 0 012.43 8.326 13.019 13.019 0 012 5V3.5z" clip-rule="evenodd" />
                            </svg>
                        </div>

                        <!-- Phone Input -->
                        <input type="tel" 
                            id="phone_number" 
                            name="phone_number" 
                            value="{{ old('phone_number', $user->phone_number) }}" 
                            autocomplete="tel"
                            placeholder="9876543210"
                            pattern="[6-9][0-9]{9}"
                            maxlength="10"
                            inputmode="numeric"
                            oninput="this.value=this.value.replace(/[^0-9]/g,'').slice(0,10)"
                            class="block w-full pl-10 px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                            required
                        >
                    </div>

                    @error('phone_number')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                
                <!-- Save Button -->
                <div class="flex items-center justify-end pt-4">
                    @if (session('status') === 'profile-updated')
                        <p class="mr-4 text-sm text-green-600"
                           x-data="{ show: true }"
                           x-show="show"
                           x-transition
                           x-init="setTimeout(() => show = false, 2000)">
                            {{ __('profile.saved') }}
                        </p>
                    @endif
                    <button type="submit" 
                            class="px-6 py-2 bg-blue-600 text-white font-medium rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        {{ __('profile.save') }}
                    </button>
                </div>
            </form>
    </div>
</div>

@push('scripts')
<script>
// Profile image preview functionality
function previewImage(input) {
    if (input.files && input.files[0]) {
        const file = input.files[0];
        
        // Validate file size (2MB)
        if (file.size > 2 * 1024 * 1024) {
            alert('File size must be less than 2MB');
            input.value = '';
            return;
        }
        
        // Validate file type
        const allowedTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/gif'];
        if (!allowedTypes.includes(file.type)) {
            alert('Please select a valid image file (JPG, PNG, GIF)');
            input.value = '';
            return;
        }
        
        const reader = new FileReader();
        reader.onload = function(e) {
            const currentAvatar = document.getElementById('current-avatar');
            currentAvatar.innerHTML = `<img src="${e.target.result}" alt="Profile Preview" class="w-20 h-20 rounded-full object-cover">`;
        };
        reader.readAsDataURL(file);
        
        // Reset remove image flag
        const removeImageInput = document.getElementById('remove_image');
        if (removeImageInput) {
            removeImageInput.value = '0';
        }
    }
}

function removeProfileImage() {
    const currentAvatar = document.getElementById('current-avatar');
    const userName = '{{ $user->initials }}';
    
    // Reset to initials
    currentAvatar.innerHTML = `<div class="w-20 h-20 bg-blue-500 rounded-full flex items-center justify-center text-white text-2xl font-bold">${userName}</div>`;
    
    // Clear file input
    document.getElementById('profile_image').value = '';
    
    // Set remove flag
    document.getElementById('remove_image').value = '1';
}

document.addEventListener('DOMContentLoaded', function() {
    const phoneInput = document.getElementById('phone_number');
    
    if (phoneInput) {
        phoneInput.addEventListener('input', function(e) {
            // Remove all non-digit characters
            let phoneNumber = e.target.value.replace(/\D/g, '');
            
            // Format the phone number as the user types
            let formattedNumber = '';
            
            // Add country code if it starts with 1 (US/Canada)
            if (phoneNumber.startsWith('1') && phoneNumber.length > 1) {
                formattedNumber = '+1 (';
                phoneNumber = phoneNumber.substring(1);
            }
            
            // Format the rest of the number
            for (let i = 0; i < phoneNumber.length; i++) {
                if (i === 0 && !formattedNumber) {
                    formattedNumber += phoneNumber[i];
                } else if (i === 3 && !formattedNumber.includes('(')) {
                    formattedNumber += ' (' + phoneNumber[i];
                } else if (i === 3 && !formattedNumber.includes(')')) {
                    formattedNumber += phoneNumber[i] + ') ';
                } else if (i === 6 && formattedNumber.includes(')')) {
                    formattedNumber += ' ' + phoneNumber[i];
                } else if (i === 6 && !formattedNumber.includes(')')) {
                    formattedNumber += ') ' + phoneNumber[i];
                } else if (i === 9) {
                    formattedNumber += '-' + phoneNumber[i];
                } else {
                    formattedNumber += phoneNumber[i];
                }
            }
            
            // Update the input value
            e.target.value = formattedNumber;
        });
    }
});
</script>
@endpush
