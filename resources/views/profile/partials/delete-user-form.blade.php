<section class="space-y-6">
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                    {{ __('Delete Account') }}
                </h2>

                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                    {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.') }}
                </p>
            </div>

            <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#confirm-user-deletion">
                {{ __('Delete Account') }}
            </button>

            <div class="modal fade" id="confirm-user-deletion" tabindex="-1" aria-labelledby="confirmUserDeletionLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form method="post" action="{{ route('profile.destroy') }}" class="p-6">
                            @csrf
                            @method('delete')

                            <div class="modal-header">
                                <h2 class="modal-title text-lg font-medium text-gray-900 dark:text-gray-100" id="confirmUserDeletionLabel">
                                    {{ __('Are you sure you want to delete your account?') }}
                                </h2>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>

                            <div class="modal-body">
                                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                                    {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.') }}
                                </p>

                                <div class="mt-6">
                                    <label for="password" class="form-label sr-only">{{ __('Password') }}</label>
                                    <input id="password" name="password" type="password" class="form-control mt-1 w-75" placeholder="{{ __('Password') }}" />

                                    <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
                                </div>
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                    {{ __('Cancel') }}
                                </button>

                                <button type="submit" class="btn btn-danger ms-3">
                                    {{ __('Delete Account') }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
