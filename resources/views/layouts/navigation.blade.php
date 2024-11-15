@php
    $user = auth()->user();
@endphp
<nav class="navbar fixed-top navbar-expand-lg bg-white rounded-desktop m-2">
    <div class="container-fluid">
        <a class="navbar-brand text-dark ms-3 pb-2" href="{{ route('edit.listing', ['id' => session('current_profile_id')]) }}"><img src="{{ asset('assets/images/linkodart_logo.png') }}" alt="profile-user" style="width: 140px;" /></a>
        <button class="navbar-toggler bg-light" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0 text-dark">
                <li class="nav-item">
                    <a class="nav-link text-dark" href="{{ route('edit.listing', ['id' => session('current_profile_id')]) }}"><i class="fa-solid fa-bars-progress me-1"></i>Links</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-dark" href="{{ route('themes.appearance', ['id' => session('current_profile_id')]) }}"><i class="fa-solid fa-sliders me-1"></i>Appearance</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-dark" href="{{ route('settings.index', ['id' => session('current_profile_id')]) }}"><i class="fa-solid fa-gear me-1"></i>Settings</a>
                </li>
                @role('admin')
                    <li class="nav-item"><a class="nav-link text-dark" href="{{ route('admin.userList') }}"><i class="fa-solid fa-users me-1"></i>Users</a></li>
                @endrole
            </ul>
            @if (!($user->userDetail->stripe_subscription_id))
                <ul class="list-unstyled topbar-nav mb-0 pb-0 me-2">
                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none"
                        xmlns="http://www.w3.org/2000/svg" class=" " role="img" aria-hidden="true"
                        aria-labelledby=" ">
                        <path d="M8.5 0.499756V6.49976H13L7.5 15.4998V9.49976H3L8.5 0.499756Z" fill="currentColor">
                        </path>
                        <path
                            d="M8.5 0.499756H9L8.07336 0.239031L8.5 0.499756ZM8.5 6.49976H8L8.5 6.99976V6.49976ZM13 6.49976L13.4266 6.76048L13 5.99976V6.49976ZM7.5 15.4998H7L7.92664 15.7605L7.5 15.4998ZM7.5 9.49976H8L7.5 8.99976V9.49976ZM3 9.49976L2.57336 9.23903L3 9.99976V9.49976ZM8 0.499756V6.49976H9V0.499756H8ZM8.5 6.99976H13V5.99976H8.5V6.99976ZM12.5734 6.23903L7.07336 15.239L7.92664 15.7605L13.4266 6.76048L12.5734 6.23903ZM8 15.4998V9.49976H7V15.4998H8ZM7.5 8.99976H3V9.99976H7.5V8.99976ZM3.42664 9.76048L8.92664 0.760481L8.07336 0.239031L2.57336 9.23903L3.42664 9.76048Z"
                            fill="currentColor"></path>
                    </svg>
                    <a href="{{ route('plans') }}">Upgrade Plan</a>
                </ul>
            @else
                {{-- @hasrole('customer') --}}
                <ul class="list-unstyled topbar-nav mb-0 pb-0 me-2">
                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none"
                        xmlns="http://www.w3.org/2000/svg" class=" " role="img" aria-hidden="true"
                        aria-labelledby=" ">
                        <path d="M8.5 0.499756V6.49976H13L7.5 15.4998V9.49976H3L8.5 0.499756Z" fill="currentColor">
                        </path>
                        <path
                            d="M8.5 0.499756H9L8.07336 0.239031L8.5 0.499756ZM8.5 6.49976H8L8.5 6.99976V6.49976ZM13 6.49976L13.4266 6.76048L13 5.99976V6.49976ZM7.5 15.4998H7L7.92664 15.7605L7.5 15.4998ZM7.5 9.49976H8L7.5 8.99976V9.49976ZM3 9.49976L2.57336 9.23903L3 9.99976V9.49976ZM8 0.499756V6.49976H9V0.499756H8ZM8.5 6.99976H13V5.99976H8.5V6.99976ZM12.5734 6.23903L7.07336 15.239L7.92664 15.7605L13.4266 6.76048L12.5734 6.23903ZM8 15.4998V9.49976H7V15.4998H8ZM7.5 8.99976H3V9.99976H7.5V8.99976ZM3.42664 9.76048L8.92664 0.760481L8.07336 0.239031L2.57336 9.23903L3.42664 9.76048Z"
                            fill="currentColor"></path>
                    </svg>
                    <a href="{{ route('pay') }}">Your Subscription</a>
                    {{-- @endhasrole --}}
                </ul>
            @endif
            
            <!--for premium user-->
            @if( $user->userDetail->user_type == 'premium')
                <button class="btn btn-outline-dark me-2" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasExample" aria-controls="offcanvasExample">
                  Switch Profile <i class="fa-solid fa-repeat ms-1"></i>
                </button>
            @endif
            
            
            <ul class="list-unstyled topbar-nav mb-0">
                <button id="generateQrCodeBtn" type="button" class="btn btn-outline-dark" data-bs-toggle="modal" data-bs-target="#shareModal">
                    Share <i class="fa-solid fa-share-alt me-1"></i>
                </button>
            </ul>
            <ul class="list-unstyled topbar-nav float-end mb-0">
                <li class="dropdown">
                    <a class="nav-link dropdown-toggle waves-effect waves-light nav-user mx-3 mt-1"
                        data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="false"
                        aria-expanded="false">
                        <span class="ms-1 nav-user-name hidden-sm mx-2 text-dark">
                            <?= ucfirst(Auth::user()->name) ?> <i class="fa-solid fa-caret-down ms-1"></i>
                        </span>
                        {{-- <img src="" alt="profile-user"
                            class="rounded-circle thumb-xs" /> --}}
                    </a>
                    <div class="dropdown-menu dropdown-menu-end">
                        <a class="dropdown-item" href="{{ route('profile.edit') }}"><i data-feather="user"
                                class="align-self-center icon-xs icon-dual me-1"></i> Profile</a>
                        <div class="dropdown-divider mb-0"></div>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <a class="dropdown-item" href="{{ route('logout') }}"
                                onclick="event.preventDefault();
                                        this.closest('form').submit();"><i
                                    data-feather="power" class="align-self-center icon-xs icon-dual me-1"></i>
                                Logout</a>
                        </form>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</nav>
