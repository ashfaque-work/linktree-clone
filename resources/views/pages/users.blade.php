@extends('layouts.app')
@section('content')
    <div class="container mt-5">
        @error('url_slug')
            <div class="alert alert-danger alert-dismissible fade show" id="alert-dismissible" role="alert">
              <strong>Error</strong> {{ $message }}
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @enderror
        <div class="row mx-auto">
            {{-- Users --}}
            <div class="col-12">
                
                <!--Social Icons-->
                <div class="row mt-4">
                    <h5>Users</h5>
                    <div class="card mt-2 border-light-subtle rounded-4">
                        <div class="card-body p-4">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>User Type</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($users as $user)
                                            <tr>
                                                <td>{{ $user->id }}</td>
                                                <td>{{ $user->name }}</td>
                                                <td>{{ $user->email }}</td>
                                                <td>{{ $user->userDetail ? $user->userDetail->user_type : 'N/A' }}</td>
                                                <td>
                                                    <form method="post" action="{{ route('admin.allowUser') }}">
                                                        @csrf
                                                        <input type="hidden" name="user_id" value="{{ $user->id }}">
                                                        <select name="user_type" class="form-select w-50 d-inline">
                                                            <option value="free" {{ $user->userDetail && $user->userDetail->user_type === 'free' ? 'selected' : '' }}>Free</option>
                                                            <option value="pro" {{ $user->userDetail && $user->userDetail->user_type === 'pro' ? 'selected' : '' }}>Pro</option>
                                                            <option value="premium" {{ $user->userDetail && $user->userDetail->user_type === 'premium' ? 'selected' : '' }}>Premium</option>
                                                        </select>
                                                        <button type="submit" class="btn btn-dark d-inline">Update</button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
