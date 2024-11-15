@extends('layouts.app')

@section('content')

@php
    $user = Auth::user();
@endphp
    <div class="container mt-5">
        <p class="fs-5">Hello, <strong>{{ $user->name }}</strong> Check your first profile link 
            <a class="" href="{{ $appearances->isNotEmpty() ? $appearances->first()->url_slug : $user->name }}" target="_blank">here</a>
        </p>
        <div class="card">
            <div class="card-header">
                <h5>Profile Lists</h5>
                <button type="button" class="btn btn-dark float-end" data-bs-toggle="modal" data-bs-target="#exampleModal">
                          Create Another
                </button>
            </div>
            <div class="card-body">
                <div class="row mx-auto">
                    <div class="col-7">
                        <ul class="nav nav-tabs mt-4" id="myTabs">
                            <li class="nav-item">
                                <a class="nav-link active" id="appearances-tab" data-bs-toggle="tab" href="#appearances">Appearances</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="listings-tab" data-bs-toggle="tab" href="#listings">Listings</a>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <!-- Appearances Tab -->
                            <div class="tab-pane fade show active" id="appearances">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>URL Slug</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($appearances as $appearance)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $appearance->url_slug }}</td>
                                            <td>
                                                <a href="{{ route('themes.appearance', $appearance->id) }}"
                                                    class="btn btn-primary btn-sm">Edit</a>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                  </table>
                            </div>
                
                            <!-- Listings Tab -->
                            <div class="tab-pane fade" id="listings">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>URL Slug</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($listings as $listing)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $listing->url_slug }}</td>
                                                <td>
                                                    <a href="{{ route('edit.listing', $listing->id) }}" class="btn btn-primary btn-sm">Edit</a>
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
