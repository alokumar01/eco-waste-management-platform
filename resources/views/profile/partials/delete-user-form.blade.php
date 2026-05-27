<section class="space-y-6 select-none">
    <header>
        <h2 class="text-base font-extrabold text-gray-900 flex items-center gap-2">
            <i class="fa-solid fa-triangle-exclamation text-red-600 text-sm"></i>
            {{ __('Delete Account') }}
        </h2>

        <p class="mt-2 text-xs text-gray-500 font-semibold leading-relaxed">
            {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.') }}
        </p>
    </header>

    <button type="button" onclick="openModal('confirm-profile-page-user-deletion')" class="px-4 py-2.5 bg-red-600 hover:bg-red-700 active:scale-[0.98] text-white text-xs font-bold rounded-xl shadow-sm transition-all flex items-center gap-2 cursor-pointer">
        <i class="fa-regular fa-trash-can"></i> {{ __('Delete Account') }}
    </button>

    <!-- Modal for Profile Page Deletion -->
    <div id="confirm-profile-page-user-deletion" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
        <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <!-- Overlay -->
            <div class="fixed inset-0 transition-opacity" aria-hidden="true" onclick="closeModal('confirm-profile-page-user-deletion')">
                <div class="absolute inset-0 bg-gray-900/60 backdrop-blur-sm"></div>
            </div>

            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            <div class="relative z-10 inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-md sm:w-full border border-gray-100">
                <form method="post" action="{{ route('profile.destroy') }}" class="p-6">
                    @csrf
                    @method('delete')

                    <div class="flex items-center gap-3 mb-4 text-red-600">
                        <div class="w-10 h-10 rounded-full bg-red-50 flex items-center justify-center text-lg shrink-0">
                            <i class="fa-solid fa-triangle-exclamation"></i>
                        </div>
                        <h3 class="text-base font-extrabold text-gray-900">
                            {{ __('Are you sure you want to delete your account?') }}
                        </h3>
                    </div>

                    <p class="text-xs text-gray-500 font-semibold leading-relaxed mb-6">
                        {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.') }}
                    </p>

                    <div class="space-y-2">
                        <label for="profile_password" class="text-[10px] font-extrabold text-gray-400 uppercase tracking-wider">{{ __('Password') }}</label>
                        <input
                            id="profile_password"
                            name="password"
                            type="password"
                            required
                            class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-xs font-semibold text-gray-700 focus:outline-none focus:ring-1 focus:ring-red-500 focus:bg-white transition-colors"
                            placeholder="{{ __('Enter your account password') }}"
                        />

                        @error('password', 'userDeletion')
                            <p class="text-[11px] text-red-600 font-semibold mt-1.5"><i class="fa-solid fa-circle-exclamation mr-1"></i>{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mt-6 flex justify-end gap-3.5">
                        <button type="button" onclick="closeModal('confirm-profile-page-user-deletion')" class="px-4 py-2 bg-gray-50 hover:bg-gray-100 text-gray-700 text-xs font-bold rounded-lg border border-gray-200 transition-colors cursor-pointer">
                            {{ __('Cancel') }}
                        </button>

                        <button type="submit" class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white text-xs font-bold rounded-lg shadow-sm transition-colors cursor-pointer">
                            {{ __('Delete Account') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Ensure Modal utility is defined or handled correctly
        if (typeof openModal !== 'function') {
            window.openModal = function(modalId) {
                document.getElementById(modalId).style.display = 'block';
            }
        }
        if (typeof closeModal !== 'function') {
            window.closeModal = function(modalId) {
                document.getElementById(modalId).style.display = 'none';
            }
        }

        @if ($errors->userDeletion->isNotEmpty())
            document.addEventListener('DOMContentLoaded', function() {
                openModal('confirm-profile-page-user-deletion');
            });
        @endif
    </script>
</section>
