@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="py-4">
            <div class="row">
                <div class="col-md-8 mx-auto">
                    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight ps-3">
                        {{ __('Profile') }}
                    </h2>
                    <div class="mb-4">
                        @include('profile.partials.update-profile-information-form')
                    </div>
                    <div class="mb-4">
                        @include('profile.partials.update-password-form')
                    </div>
                    <div>
                        @include('profile.partials.delete-user-form')
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
