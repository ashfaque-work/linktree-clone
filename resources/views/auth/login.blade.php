<x-guest-layout>
    <div class="container mt-5">
        <div class="row justify-content-center align-items-center">
            <div class="col-12 col-md-5">
                <div class="card">
                    <div class="card-header">
                        Login your account
                    </div>
                    <div class="card-body">
                        <!-- Session Status -->
                        <x-auth-session-status class="mb-4" :status="session('status')" />
            
                        <form method="POST" action="{{ route('login') }}" class="mt-4">
                            @csrf
                    
                            <!-- Email Address -->
                            <div class="mb-3">
                                <x-input-label for="email" :value="__('Email')" />
                                <x-text-input id="email" class="form-control" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                                <x-input-error :messages="$errors->get('email')" class="mt-2" />
                            </div>
                    
                            <!-- Password -->
                            <div class="mb-3">
                                <x-input-label for="password" :value="__('Password')" />
                    
                                <x-text-input id="password" class="form-control"
                                              type="password"
                                              name="password"
                                              required autocomplete="current-password" />
                    
                                <x-input-error :messages="$errors->get('password')" class="mt-2" />
                            </div>
                    
                            <!-- Remember Me -->
                            <div class="mb-3">
                                <div class="form-check">
                                    <input id="remember_me" type="checkbox" class="form-check-input" name="remember">
                                    <label for="remember_me" class="form-check-label">{{ __('Remember me') }}</label>
                                </div>
                            </div>
                    
                            <div class="d-flex justify-content-end align-items-center mt-4">
                                @if (Route::has('register'))
                                    <a class="text-decoration-none me-3" href="{{ route('register') }}">
                                        Don't have an account?
                                    </a>
                                @endif
                    
                                <x-primary-button>
                                    {{ __('Log in') }}
                                </x-primary-button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
