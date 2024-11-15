@php
    function getSocialIconClass($socialType)
    {
        switch ($socialType) {
            case 'AppleAppStore':
                return 'fa-brands fa-app-store-ios';
            case 'AppleMusic':
                return 'fa fa-apple';
            case 'ApplePodcast':
                return 'fa fa-podcast';
            case 'Discord':
                return 'fa-brands fa-discord';
            case 'Email':
                return 'fa fa-envelope';
            case 'Facebook':
                return 'fa fa-facebook';
            case 'Github':
                return 'fa fa-github';
            case 'Instagram':
                return 'fa fa-instagram';
            case 'LinkedIn':
                return 'fa fa-linkedin';
            case 'Payment':
                return 'fa-solid fa-dollar-sign';
            case 'Phone':
                return 'fa-solid fa-phone';
            case 'Pinterest':
                return 'fa fa-pinterest';
            case 'Snapchat':
                return 'fa fa-snapchat';
            case 'Spotify':
                return 'fa fa-spotify';
            case 'Telegram':
                return 'fa fa-telegram';
            case 'X':
                return 'fa fa-twitter';
            case 'Youtube':
                return 'fa fa-youtube';
            case 'WhatsApp':
                return 'fa fa-whatsapp';
            default:
                return 'fa-solid fa-share-from-square';
        }
    }
    
    // Assuming $socialIconsData is the array of social icons data
    $sortedSocialIcons = collect($socialIcons)->sortBy('priority');
@endphp
@extends('layouts.master')
@section('content')
    <!-- Content container -->
    <div class="container">
        <div class="text-center pt-5">
            <!-- Image and name container. Change to your picture here. -->
            @if (isset($profile_image))
                <img src="{{ url('storage/' . $profile_image) }}" class="mx-auto rounded-circle profile-img" alt="Profile image">
            @else
                <img src="{{ asset('assets/images/default-image.jpg') }}" alt="Image" class="mb-2 rounded-circle profile-img">
            @endif
            <div class="my-4">
                <p class="text-dark fw-bold fs-4 mb-1 preview-name">{{ $title }}</p>
                <p class="text-dark fw-semibold fs-6 preview-bio">{{ $bio }}</p>
            </div>

            {{-- Links Section --}}
            <div class="d-flex flex-column align-items-center">
                @if (isset($data))
                    @foreach ($data as $key => $value)

                        @if (isset($value->visibility))

                            @if ($value->visibility == 'true')
                                <div class="mb-2 btn-response">
                                    <div class="p-0 btn-color position-relative">
                                        @if (isset($value->thumbnail))
                                            <img src="{{ url('storage/') . '/' . $value->thumbnail }}"
                                                class="position-absolute top-50 start-10 translate-middle-y thumbnail-image"
                                                style="
                                                            width: 30px;
                                                            height: 30px;
                                                            border-radius: 5px;
                                                            margin-left: 12px;
                                                        ">
                                        @endif
                                        <a href="{{ $value->url }}" class="btn btn-lg btn-rounded w-100 a-response btn-links"
                                            target="_blank" style="padding-left:35px; padding-right:30px;">{{ $value->title }}</a>
                                        <button type="button"
                                            class="btn position-absolute top-50 end-0 translate-middle-y rounded-circle btn-links"
                                            data-bs-toggle="modal" data-bs-target="#modal_{{ $key }}">
                                            <i class="fas fa-ellipsis-h light-icon"></i>
                                        </button>
                                    </div>
                                </div>
                            @endif

                        @else                        
                            <div class="mb-3 btn-response">
                                <div class="p-0 btn-color position-relative">
                                    @if (isset($value->thumbnail))
                                        <img src="{{ url('storage') . '/' . $value->thumbnail }}"
                                            class="thumbnail-image position-absolute top-50 start-10 translate-middle-y"
                                            style="
                                                            width: 30px;
                                                            height: 30px;
                                                            border-radius: 5px;
                                                            margin-left: 5px;
                                                        ">
                                    @endif
                                    <a href="{{ $value->url }}" class="btn btn-lg btn-rounded w-100 a-response"
                                        target="_blank">{{ $value->title }}</a>
                                    <button type="button"
                                        class="btn position-absolute top-50 end-0 translate-middle-y rounded-circle"
                                        data-bs-toggle="modal" data-bs-target="#modal_{{ $key }}">
                                        <i class="fas fa-ellipsis-h light-icon"></i>
                                    </button>
                                </div>
                            </div>
                        @endif

                        {{-- Sharing Modal --}}
                        <div class="modal fade" id="modal_{{ $key }}" tabindex="-1" aria-labelledby="modalLabel"
                            aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="modalLabel">Share this link</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body popup-share-btn">
                                        <div class="card mb-2 w-100">
                                            <div class="d-flex p-0 card-body btn-modal">
                                                <a class="btn w-100" id="shareSnapchat"
                                                    href="https://www.snapchat.com/scan?attachmentUrl={{ $value->url }}"
                                                    target="_blank">
                                                    <div class="float-start">
                                                        <i class="fa-brands fa-snapchat fa-lg me-2"></i>
                                                        <p class="d-inline">Share on Snapchat</p>
                                                    </div>
                                                    <i class="fas fa-chevron-right float-end mt-1"></i>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="card mb-2 w-100">
                                            <div class="d-flex p-0 card-body btn-modal">
                                                <a class="btn w-100" id="shareFacebook"
                                                    href="https://www.facebook.com/sharer.php?{{ $value->url }}"
                                                    target="_blank">
                                                    <div class="float-start">
                                                        <i class="fa-brands fa-facebook fa-lg me-2"></i>
                                                        <p class="d-inline">Share on Facebook</p>
                                                    </div>
                                                    <i class="fas fa-chevron-right float-end mt-1"></i>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="card mb-2 w-100">
                                            <div class="d-flex p-0 card-body btn-modal">
                                                <a class="btn w-100" id="shareLinkedin"
                                                    href="https://www.linkedin.com/sharing/share-offsite/?url={{ $value->url }}"
                                                    target="_blank">
                                                    <div class="float-start">
                                                        <i class="fa-brands fa-linkedin fa-lg me-2"></i>
                                                        <p class="d-inline">Share on LinkedIn</p>
                                                    </div>
                                                    <i class="fas fa-chevron-right float-end mt-1"></i>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="card mb-2 w-100">
                                            <div class="d-flex p-0 card-body btn-modal">
                                                <a class="btn w-100" id="shareX"
                                                    href="https://x.com/intent/tweet?text={{ $value->title }} - {{ $value->url }}"
                                                    target="_blank">
                                                    <div class="float-start">
                                                        <i class="fa-brands fa-x-twitter fa-lg me-2"></i>
                                                        <p class="d-inline">Share on X</p>
                                                    </div>
                                                    <i class="fas fa-chevron-right float-end mt-1"></i>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="card mb-2 w-100">
                                            <div class="d-flex p-0 card-body btn-modal">
                                                <a class="btn w-100" id="shareWhatsapp"
                                                    href="https://wa.me/?text={{ $value->title }} - {{ $value->url }}"
                                                    target="_blank">
                                                    <div class="float-start">
                                                        <i class="fa-brands fa-whatsapp fa-lg me-2"></i>
                                                        <p class="d-inline">Share via WhatsApp</p>
                                                    </div>
                                                    <i class="fas fa-chevron-right float-end mt-1"></i>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="card mb-2 w-100">
                                            <div class="d-flex p-0 card-body btn-modal">
                                                <a class="btn w-100" id="shareMessenger" href="https://www.messenger.com/new"
                                                    target="_blank">
                                                    <div class="float-start">
                                                        <i class="fa-brands fa-facebook-messenger fa-lg me-2"></i>
                                                        <p class="d-inline">Share via Messenger</p>
                                                    </div>
                                                    <i class="fas fa-chevron-right float-end mt-1"></i>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="card mb-2 w-100">
                                            <div class="d-flex p-0 card-body btn-modal">
                                                <a class="btn w-100" id="shareEmail"
                                                    href="mailto:?subject= {{ 'Check Out this LinkHive!' }} &body= {{ $value->title }} - {{ $value->url }}"
                                                    target="_blank">
                                                    <div class="float-start">
                                                        <i class="fa fa-envelope fa-lg me-2"></i>
                                                        <p class="d-inline">Share via Email</p>
                                                    </div>
                                                    <i class="fas fa-chevron-right float-end mt-1"></i>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="card mb-2 mt-4 w-100">
                                            <div class="d-flex align-items-center p-0 card-body">
                                                <input class="form-control" type="text" id="link"
                                                    value="{{ url($urlSlug) }}">
                                                <button class="btn" onclick="myFunction(this)">Copy</button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-dark share-close-btn"
                                            data-bs-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="mb-2 w-50">
                        <div class="p-0 btn-color position-relative">
                            <a href="#" class="btn btn-lg btn-rounded w-100">
                                <p></p>
                            </a>
                        </div>
                    </div>
                    <div class="mb-2 w-50">
                        <div class="p-0 btn-color position-relative">
                            <a href="#" class="btn btn-lg btn-rounded w-100">
                                <p></p>
                            </a>
                        </div>
                    </div>
                    <div class="mb-2 w-50">
                        <div class="p-0 btn-color position-relative">
                            <a href="#" class="btn btn-lg btn-rounded w-100">
                                <p></p>
                            </a>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        {{-- Social Icons --}}
        <div class="row justify-content-center mt-2">
            @foreach ($sortedSocialIcons as $socialType => $socialInfo)
                @if ($socialInfo['status'])
                    <div class="col-auto">
                        @if ($socialType === 'Email')
                            <a href="mailto:{{ $socialInfo['value'] }}" class="btn btn-lg btn-rounded" target="_blank">
                                <i class="fa fa-envelope social-icon-color"></i>
                            </a>
                        @elseif ($socialType === 'WhatsApp')
                            <a href="https://api.whatsapp.com/send?phone={{ $socialInfo['value'] }}" class="btn btn-lg btn-rounded" target="_blank">
                                <i class="fa fa-whatsapp social-icon-color"></i>
                            </a>
                        @elseif ($socialType === 'Phone')
                            <a href="tel:{{ $socialInfo['value'] }}" class="btn btn-lg btn-rounded" target="_blank">
                                <i class="fa-solid fa-phone social-icon-color"></i>
                            </a>
                        @else
                            <a href="{{ $socialInfo['value'] }}" class="btn btn-lg btn-rounded" target="_blank">
                                <i class="{{ getSocialIconClass($socialType) }} social-icon-color"></i>
                            </a>
                        @endif
                    </div>
                @endif
            @endforeach
        </div>
        
    </div>
    
    <script>
        function myFunction(button) {
            var copyText = document.getElementById("link");
            copyText.select();
            copyText.setSelectionRange(0, 99999);
            navigator.clipboard.writeText(copyText.value);

            button.textContent = 'Copied';
            setTimeout(function() {
                button.textContent = 'Copy';
            }, 2000);
        }
    </script>
    
@endsection
