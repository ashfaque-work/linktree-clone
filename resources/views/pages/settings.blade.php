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
            {{-- Add QR / Icon Section --}}
            <div class="col-7" style="min-width: 400px;">
                <!--For QR code Icon-->
                <div class="row">
                    <h5>QR-Code Icon</h5>
                    <div class="card mt-2 border-light-subtle rounded-4">
                        <div class="card-body">
                            <div class="mb-3">
                                <div class="d-flex align-items-center">
                                    <div class="qr-image-wrapper" id="qr-image-wrapper">
                                        @if ($appearance && $appearance->logo)
                                            <img id="uploadedImage" src="{{ asset('storage/' . $appearance->logo) }}"
                                                alt="QR-Icon">
                                        @elseif($appearance && $appearance->profile_title)
                                            {{ strtoupper(substr($appearance->profile_title, 0, 1)) }}
                                        @else
                                            @
                                        @endif
                                    </div>
                                    <div class="ms-4 flex-grow-1">
                                        <button type="button" class="btn btn-dark rounded-pill w-100 mb-2"
                                            data-bs-toggle="modal" data-bs-target="#uploadImageModal">Upload Logo</button>
                                        <button id="removeQrIconButton" type="button"
                                            class="btn btn-outline-secondary rounded-pill w-100"
                                            @if (!$appearance || !$appearance->logo) disabled @endif>Remove</button>
                                    </div>
                                    <!-- Upload Image Modal -->
                                    <div class="modal fade" id="uploadImageModal" tabindex="-1"
                                        aria-labelledby="uploadImageModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header py-2">
                                                    <h5 class="modal-title mt-0" id="uploadImageModalLabel">Upload Profile Image
                                                    </h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form id="uploadQrIconImageForm" enctype="multipart/form-data">
                                                        @csrf
                                                        <input type="file" id="input-file-now-custom-3" name="qrIcon" class="form-control dropify" accept=".jpg, .jpeg, .png" data-default-file="{{ $user->appearance && $user->appearance->image ? asset('storage/' . $user->appearance->image) : '' }}">
                                                        <button id="uploadQrIconButton" type="button" class="btn btn-dark mt-3 float-end" >Upload</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!--Social Icons-->
                <div class="row mt-4">
                    <h5>Social Icons</h5>
                    <div class="card mt-2 border-light-subtle rounded-4">
                        <div class="card-body p-4">
                            <!-- Button trigger modal -->
                            <button type="button" class="btn btn-dark" data-bs-toggle="modal"
                                data-bs-target="#addSocialIconModal">
                                Add Icon
                            </button>
    
                            <!-- Add Icon Modal -->
                            <div class="modal fade" id="addSocialIconModal" tabindex="-1"
                                aria-labelledby="addSocialIconModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                                    <div class="modal-content">
                                        <div class="modal-header text-center">
                                            <button type="button" class="btn btn-light" id="backToIcons">
                                                <i class="fa-solid fa-chevron-left align-self-center" aria-hidden="true"></i>
                                            </button>
                                            <h5 class="modal-title mt-0 mx-auto" id="addSocialIconModalLabel">Add Icon</h5>
                                            <button type="button" class="btn-close mx-0" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body" id="socialModalBody">
                                            <!-- Social Icon Selection Buttons -->
                                            <div class="d-flex flex-column" id="socialIconButtonGroup">
                                                <button
                                                    class="social-icon-btn btn btn-light my-1 py-2 d-flex justify-content-between"
                                                    type="button" data-social="AppleAppStore">
                                                    <p class="text-black text-md font-semibold mb-0">Apple App Store</p>
                                                    <i class="fa-solid fa-chevron-right align-self-center"
                                                        aria-hidden="true"></i>
                                                </button>
                                                <button
                                                    class="social-icon-btn btn btn-light my-1 py-2 d-flex justify-content-between"
                                                    type="button" data-social="AppleMusic">
                                                    <p class="text-black text-md font-semibold mb-0">Apple Music</p>
                                                    <i class="fa-solid fa-chevron-right align-self-center"
                                                        aria-hidden="true"></i>
                                                </button>
                                                <button
                                                    class="social-icon-btn btn btn-light my-1 py-2 d-flex justify-content-between"
                                                    type="button" data-social="ApplePodcast">
                                                    <p class="text-black text-md font-semibold mb-0">Apple Podcast</p>
                                                    <i class="fa-solid fa-chevron-right align-self-center"
                                                        aria-hidden="true"></i>
                                                </button>
                                                <button
                                                    class="social-icon-btn btn btn-light my-1 py-2 d-flex justify-content-between"
                                                    type="button" data-social="Discord">
                                                    <p class="text-black text-md font-semibold mb-0">Discord</p>
                                                    <i class="fa-solid fa-chevron-right align-self-center"
                                                        aria-hidden="true"></i>
                                                </button>
                                                <button
                                                    class="social-icon-btn btn btn-light my-1 py-2 d-flex justify-content-between"
                                                    type="button" data-social="Email">
                                                    <p class="text-black text-md font-semibold mb-0">Email</p>
                                                    <i class="fa-solid fa-chevron-right align-self-center"
                                                        aria-hidden="true"></i>
                                                </button>
    
                                                <button
                                                    class="social-icon-btn btn btn-light my-1 py-2 d-flex justify-content-between"
                                                    type="button" data-social="Facebook">
                                                    <p class="text-black text-md font-semibold mb-0">Facebook</p>
                                                    <i class="fa-solid fa-chevron-right align-self-center"
                                                        aria-hidden="true"></i>
                                                </button>
                                                <button
                                                    class="social-icon-btn btn btn-light my-1 py-2 d-flex justify-content-between"
                                                    type="button" data-social="Github">
                                                    <p class="text-black text-md font-semibold mb-0">Github</p>
                                                    <i class="fa-solid fa-chevron-right align-self-center"
                                                        aria-hidden="true"></i>
                                                </button>
                                                <button
                                                    class="social-icon-btn btn btn-light my-1 py-2 d-flex justify-content-between"
                                                    type="button" data-social="Instagram">
                                                    <p class="text-black text-md font-semibold mb-0">Instagram</p>
                                                    <i class="fa-solid fa-chevron-right align-self-center"
                                                        aria-hidden="true"></i>
                                                </button>
                                                <button
                                                    class="social-icon-btn btn btn-light my-1 py-2 d-flex justify-content-between"
                                                    type="button" data-social="LinkedIn">
                                                    <p class="text-black text-md font-semibold mb-0">LinkedIn</p>
                                                    <i class="fa-solid fa-chevron-right align-self-center"
                                                        aria-hidden="true"></i>
                                                </button>
                                                <button
                                                    class="social-icon-btn btn btn-light my-1 py-2 d-flex justify-content-between"
                                                    type="button" data-social="Payment">
                                                    <p class="text-black text-md font-semibold mb-0">Payment</p>
                                                    <i class="fa-solid fa-chevron-right align-self-center"
                                                        aria-hidden="true"></i>
                                                </button>
                                                <button
                                                    class="social-icon-btn btn btn-light my-1 py-2 d-flex justify-content-between"
                                                    type="button" data-social="Pinterest">
                                                    <p class="text-black text-md font-semibold mb-0">Pinterest</p>
                                                    <i class="fa-solid fa-chevron-right align-self-center"
                                                        aria-hidden="true"></i>
                                                </button>
                                                <button
                                                    class="social-icon-btn btn btn-light my-1 py-2 d-flex justify-content-between"
                                                    type="button" data-social="Phone">
                                                    <p class="text-black text-md font-semibold mb-0">Phone</p>
                                                    <i class="fa-solid fa-chevron-right align-self-center"
                                                        aria-hidden="true"></i>
                                                </button>
                                                <button
                                                    class="social-icon-btn btn btn-light my-1 py-2 d-flex justify-content-between"
                                                    type="button" data-social="Snapchat">
                                                    <p class="text-black text-md font-semibold mb-0">Snapchat</p>
                                                    <i class="fa-solid fa-chevron-right align-self-center"
                                                        aria-hidden="true"></i>
                                                </button>
                                                <button
                                                    class="social-icon-btn btn btn-light my-1 py-2 d-flex justify-content-between"
                                                    type="button" data-social="Spotify">
                                                    <p class="text-black text-md font-semibold mb-0">Spotify</p>
                                                    <i class="fa-solid fa-chevron-right align-self-center"
                                                        aria-hidden="true"></i>
                                                </button>
                                                <button
                                                    class="social-icon-btn btn btn-light my-1 py-2 d-flex justify-content-between"
                                                    type="button" data-social="Telegram">
                                                    <p class="text-black text-md font-semibold mb-0">Telegram</p>
                                                    <i class="fa-solid fa-chevron-right align-self-center"
                                                        aria-hidden="true"></i>
                                                </button>
                                                <button
                                                    class="social-icon-btn btn btn-light my-1 py-2 d-flex justify-content-between"
                                                    type="button" data-social="X">
                                                    <p class="text-black text-md font-semibold mb-0">X (formerly Twitter)</p>
                                                    <i class="fa-solid fa-chevron-right align-self-center"
                                                        aria-hidden="true"></i>
                                                </button>
                                                <button
                                                    class="social-icon-btn btn btn-light my-1 py-2 d-flex justify-content-between"
                                                    type="button" data-social="Youtube">
                                                    <p class="text-black text-md font-semibold mb-0">Youtube</p>
                                                    <i class="fa-solid fa-chevron-right align-self-center"
                                                        aria-hidden="true"></i>
                                                </button>
                                                <button
                                                    class="social-icon-btn btn btn-light my-1 py-2 d-flex justify-content-between"
                                                    type="button" data-social="WhatsApp">
                                                    <p class="text-black text-md font-semibold mb-0">WhatsApp</p>
                                                    <i class="fa-solid fa-chevron-right align-self-center"
                                                        aria-hidden="true"></i>
                                                </button>
                                            </div>
                                            <!-- Dynamic content based on selected social icon -->
                                            <div class="mt-3" id="socialIconContent">
                                                <!-- Content will be dynamically updated here -->
                                                <div class="form-floating mb-3">
                                                    <input type="text" class="form-control" name="socialType"
                                                        id="socialType" value="">
                                                    <label for="socialType"></label>
                                                    <div class="form-text"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-dark" id="saveSocialIcon">Save</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
    
                            <!-- Existing Social Links -->
                            <div id="socialLinksContainer" class="mt-4">
                            </div>
                            <p>Drag and drop the icons above to reorder them.</p>
    
                            <!-- Edit / Delete Icon Modal  -->
                            <div class="modal fade" id="editSocialIconModal" tabindex="-1" role="dialog"
                                aria-labelledby="editSocialIconModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header border-bottom-0">
                                            <h5 class="modal-title mt-0" id="editSocialIconModalLabel">Edit <span
                                                    id="editedSocialType"></span></h5>
                                            <button type="button" class="btn-close mx-0" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="form-floating mb-3">
                                                <input type="text" class="form-control" id="editedSocialValue"
                                                    placeholder="Edit Icon Value">
                                                <input type="hidden" id="editedPriority">
                                                <input type="hidden" id="editedStatus">
                                                <label for="editedSocialValue">Edit Icon:</label>
                                            </div>
                                            <div id="errorMessageEdit" class="text-danger"></div>
                                            <div class="btn-group float-end mt-3" role="group" aria-label="Basic example">
                                                <button type="button" class="btn btn-dark"
                                                    id="saveEditedSocialIcon">Save</button>
                                                <button id="removeSocialIcon" class="btn btn-danger"
                                                    data-bs-target="#confirmationModal" data-bs-toggle="modal"
                                                    data-bs-dismiss="modal">Remove Icon</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
    
                            <!-- Confirmation Modal -->
                            <div class="modal fade" id="confirmationModal" tabindex="-1" role="dialog"
                                aria-labelledby="confirmationModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header border-bottom-0">
                                            <h5 class="modal-title" id="confirmationModalLabel">Confirmation</h5>
                                            <button type="button" class="btn-close mx-0" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div>
                                                Are you sure you want to remove this icon?
                                            </div>
                                            <div class="float-end mt-4">
                                                <button type="button" class="btn btn-danger"
                                                    id="removeSocialIconConfirmed">Remove
                                                </button>
                                            </div>
    
                                        </div>
                                    </div>
                                </div>
                            </div>
    
                        </div>
                    </div>
                </div>
            </div>
            
            {{-- Preview Section --}}
            <div class="col-5" style="min-width: 400px;">
                <h5>Preview</h5>
                <div class="d-flex justify-content-center align-items-center">
                    <iframe src="/{{ $url_slug }}" scrolling="yes" id="theme-preview-iframe" width="270px" height="520px"
                        style="border:10px solid black; border-radius:35px;">
                    </iframe>
                </div>
            </div>
        </div>
    </div>


    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.14.0/Sortable.min.js"></script>
    <script>
        $(document).ready(function() {
            const themePreviewIframe = document.getElementById('theme-preview-iframe');
            const uploadQrIconImageForm = document.getElementById('uploadQrIconImageForm');
            const uploadQrIconButton = document.getElementById('uploadQrIconButton');
            const removeQrIconButton = document.getElementById('removeQrIconButton');
            // Declare initialSocialIcons globally
            var initialSocialIcons = @json($socialIcons);
            
            uploadQrIconButton.addEventListener('click', uploadQrIcon);
            removeQrIconButton.addEventListener('click', removeQrIcon);
            themePreviewIframe.addEventListener('load', function () {
                preventModalClick();
            });
        
            // Uploading qrIcon image
            function uploadQrIcon() {
                const formData = new FormData(uploadQrIconImageForm);
                $.ajax({
                    url: '{{ route('qrIcon.upload') }}',
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        console.log('Profile image uploaded successfully');
    
                        const qrImageWrapper = document.getElementById('qr-image-wrapper');
                        const removeQrIconButton = document.getElementById('removeQrIconButton');
    
                        // Remove any existing content inside the qr-image-wrapper
                        while (qrImageWrapper.firstChild) {
                            qrImageWrapper.removeChild(qrImageWrapper.firstChild);
                        }
    
                        // If the image exists, create and append the img tag
                        if (response.qrIcon) {
                            const img = document.createElement('img');
                            img.id = 'profileImage';
                            img.src = '{{ asset('storage/') }}' + '/' + response.qrIcon;
                            img.alt = 'Profile Image';
                            qrImageWrapper.appendChild(img);
    
                            // Enable the "Remove" button if an image is present
                            removeQrIconButton.removeAttribute('disabled');
                        } else {
                            // If the profile_title is not null, show its first letter, else show "@"
                            const contentToShow = response.profile_title ? response.profile_title.charAt(0) : '@';
    
                            // Create and append the content
                            const content = document.createTextNode(contentToShow);
                            qrImageWrapper.appendChild(content);
    
                            // Disable the "Remove" button if no image is present
                            removeQrIconButton.setAttribute('disabled', true);
                        }
                        setTimeout(function() {
                            if (response.url_slug) {
                                themePreviewIframe.src = "{{ url('') }}" + '/' + response.url_slug;
                            }
                        }, 2000);
    
                        $('#uploadImageModal').modal('hide'); // Close the modal
                    },
                    error: function(error) {
                        console.error('Error uploading profile image', error);
                    }
                });
            }
        
            // Removing qrIcon image
            function removeQrIcon() {
                $.ajax({
                    url: '{{ route('qrIcon.delete') }}',
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                    },
                    success: function(response) {
                        console.log('Profile image removed successfully');
    
                        const qrImageWrapper = document.getElementById('qr-image-wrapper');
                        const removeQrIconButton = document.getElementById('removeQrIconButton');
    
                        // Remove any existing content inside the qrImageWrapper
                        while (qrImageWrapper.firstChild) {
                            qrImageWrapper.removeChild(qrImageWrapper.firstChild);
                        }
    
                        // If the image exists, create and append the img tag
                        if (response.image) {
                            const img = document.createElement('img');
                            img.id = 'profileImage';
                            img.src = '{{ asset('storage/') }}' + '/' + response.image;
                            img.alt = 'Profile Image';
                            qrImageWrapper.appendChild(img);
    
                            // Enable the "Remove" button if an image is present
                            removeQrIconButton.removeAttribute('disabled');
                        } else {
                            // If the profile_title is not null, show its first letter, else show "@"
                            const contentToShow = response.profile_title ? response.profile_title.charAt(0) : '@';
    
                            // Create and append the content
                            const content = document.createTextNode(contentToShow);
                            qrImageWrapper.appendChild(content);
    
                            // Disable the "Remove" button if no image is present
                            removeQrIconButton.setAttribute('disabled', true);
                        }
                    },
                    error: function(error) {
                        console.error('Error removing profile image', error);
                    }
                });
            }
        
            // for preventing opening model
            function preventModalClick(){
                var iframeDocument = themePreviewIframe.contentDocument;
                var buttons = iframeDocument.querySelectorAll('.rounded-circle');
                buttons.forEach(function (button) {
                    button.removeAttribute('data-bs-target');
                    button.removeAttribute('data-bs-toggle');
                });
            }
            
            // Hide error message
            document.addEventListener("DOMContentLoaded", function() {
                var alertDiv = document.getElementById("alert-dismissible");
                if (alertDiv) {
                    setTimeout(function() {
                        alertDiv.classList.add("d-none");
                    }, 5000);
                }
            });
        

            //Social Icon script - start
            // Function to show social icon buttons and hide back button
            function updateSocialIconButtons() {
                // Clear the content
                $('#socialIconContent').html('').data('social', '');
                // Remove the hide class to show the social icon buttons
                $('#socialIconButtonGroup').removeClass('hide');
                // Hide the back button
                $('#backToIcons').hide();

                $('#saveSocialIcon').hide();

                // Enable all social icon buttons
                $('.social-icon-btn').prop('disabled', false);

                // Update the buttons for icons that are already added
                $('.social-icon-btn').each(function() {
                    var socialType = $(this).data('social');
                    if (initialSocialIcons && initialSocialIcons[socialType]) {
                        // If the icon is already added, disable the button and show "Already added" text
                        $(this).prop('disabled', true);
                        $(this).html(`
                            <p class="fs-6 mb-0">${socialType}</p>
                            <p class="text-success fw-normal mb-0">Already added</p>
                        `);
                    } else {
                        // If the icon is not added, enable the button and show the arrow icon
                        $(this).prop('disabled', false);
                        $(this).html(`
                            <p class="fs-6 fw-normal mb-0">${socialType}</p>
                            <i class="fa-solid fa-chevron-right align-self-center" aria-hidden="true"></i>
                        `);
                    }
                });

                // Update the buttons for icons that have been removed
                $('.social-link-removed').each(function() {
                    var socialType = $(this).data('social');
                    // Enable the button for the removed icon
                    $(`.social-icon-btn[data-social="${socialType}"]`).prop('disabled', false);
                    // Reset the button content
                    $(this).removeClass('social-link-removed').html(`
                        <p class="fs-6 fw-normal mb-0">${socialType}</p>
                        <i class="fa-solid fa-chevron-right align-self-center" aria-hidden="true"></i>
                    `);
                });
            }

            // Function to get the appropriate icon based on social link type
            function getSocialIcon(socialType) {
                switch (socialType) {
                    case 'AppleAppStore':
                        return '<i class="fa-brands fa-app-store-ios"></i>';
                    case 'AppleMusic':
                        return '<i class="fa fa-apple"></i>';
                    case 'ApplePodcast':
                        return '<i class="fa fa-podcast"></i>';
                    case 'Discord':
                        return '<i class="fa-brands fa-discord"></i>';
                    case 'Email':
                        return '<i class="fa fa-envelope"></i>';
                    case 'Facebook':
                        return '<i class="fa fa-facebook"></i>';
                    case 'Github':
                        return '<i class="fa fa-github"></i>';
                    case 'Instagram':
                        return '<i class="fa fa-instagram"></i>';
                    case 'LinkedIn':
                        return '<i class="fa fa-linkedin"></i>';
                    case 'Payment':
                        return '<i class="fa-solid fa-dollar-sign"></i>';
                    case 'Phone':
                        return '<i class="fa-solid fa-phone"></i>';
                    case 'Pinterest':
                        return '<i class="fa fa-pinterest"></i>';
                    case 'Snapchat':
                        return '<i class="fa fa-snapchat"></i>';
                    case 'Spotify':
                        return '<i class="fa fa-spotify"></i>';
                    case 'Telegram':
                        return '<i class="fa fa-telegram"></i>';
                    case 'X':
                        return '<i class="fa fa-twitter"></i>';
                    case 'Youtube':
                        return '<i class="fa fa-youtube"></i>';
                    case 'WhatsApp':
                        return '<i class="fa fa-whatsapp"></i>';
                    default:
                        return '<i class="fa-solid fa-share-from-square"></i>';
                }
            }

            // Function to update the social links container with the latest data
            function updateSocialLinksContainer(socialLinks) {
                var container = $('#socialLinksContainer');
                if (!socialLinks) {
                    console.error('socialLinks is undefined');
                    return;
                }
                container.empty(); // Clear existing content

                if (typeof socialLinks === 'object' && socialLinks !== null) {
                    // Sort social links based on priority
                    var sortedSocialLinks = Object.entries(socialLinks).sort((a, b) => a[1].priority - b[1]
                        .priority);

                    // Iterate over the sorted social links
                    sortedSocialLinks.forEach(function([socialType, link], index) {
                        var socialIcon = getSocialIcon(socialType);
                        var priority = link.priority !== undefined ? link.priority : index;
                        var value = link.value !== undefined ? link.value : '';
                        var status = link.status !== undefined ? link.status : true;

                        let html = `
                        <div class="card mb-2 socialLinkCard draggable" data-priority="${priority}">
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col-1 icon-container">
                                        <i class="fa-solid fa-ellipsis-vertical"></i>
                                    </div>
                                    <div class="col-10 editIcon">
                                        <label id="${socialType}" class="socialLinks fs-5" data-priority="${priority}" data-value="${value}">
                                            ${socialIcon}<span class="mx-3">${socialType}</span>
                                        </label>
                                        
                                        <i class="fa fa-pencil float-end pt-2" data-toggle="modal" data-target="#editSocialIconModal"
                                        data-social-type="${socialType}" data-value="${value}" data-priority="${priority}" data-status="${status.toString()}">
                                        </i>
                                    </div>
                                    <div class="col-1 text-end">
                                        <div class="form-check form-switch">
                                            <input type="hidden" value="${status}">
                                            <input class="form-check-input toggle-switch" type="checkbox" id="toggleSwitch${priority}" data-status="${status.toString()}" ${status.toString() === 'true' ? 'checked' : ''}>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        `;
                        container.append(html);

                        // Update the data-value attribute in the label when an icon is already added
                        $('#' + socialType).data('value', value);
                    });

                    // Make the icon container draggable
                    makeIconContainerDraggable();
                } else {
                    console.error('socialLinks has an unsupported structure:', socialLinks);
                }
            }

            // Function to update content based on selected social icon
            function updateSocialIconContent(socialType) {
                var content = '';
                var label = '';
                var hintText = '';
                var modalTitle = 'Add Icon';

                if (socialType === 'AppleAppStore') {
                    label = 'Enter Apple Podcast URL*';
                    hintText = 'Example: https://apps.apple.com/us/yourapp/url1234567890';
                    modalTitle = 'Add Apple App Store Icon';
                } else if (socialType === 'AppleMusic') {
                    label = 'Enter Apple Music URL*';
                    hintText = 'Example: https://music.apple.com/us/album/youralbum';
                    modalTitle = 'Add Apple Music Icon';
                } else if (socialType === 'ApplePodcast') {
                    label = 'Enter Apple Podcast URL*';
                    hintText = 'Example: https://podcasts.apple.com/us/podcast/yourpodcast/123456789';
                    modalTitle = 'Add Apple Podcast Icon';
                } else if (socialType === 'Discord') {
                    label = 'Enter discord URL*';
                    hintText = 'Example: https://discord.com/invite/yourchannel';
                    modalTitle = 'Add Discord Icon';
                } else if (socialType === 'Email') {
                    label = 'Enter Email Address*';
                    hintText = 'Example: your@emailaddress.com';
                    modalTitle = 'Add Email Icon';
                } else if (socialType === 'Facebook') {
                    label = 'Enter Facebook URL*';
                    hintText = 'Example: https://facebook.com/facebookpageurl';
                    modalTitle = 'Add Facebook Icon';
                } else if (socialType === 'Github') {
                    label = 'Enter Github URL*';
                    hintText = 'Example: https://www.github.com/username';
                    modalTitle = 'Add Github Icon';
                } else if (socialType === 'Instagram') {
                    label = 'Enter Instagram Username*';
                    hintText = 'Example: https://www.instagram.com/instagramusername';
                    modalTitle = 'Add Instagram Icon';
                } else if (socialType === 'LinkedIn') {
                    label = 'Enter LinkedIn URL*';
                    hintText = 'Example: https://linkedin.com/in/username';
                    modalTitle = 'Add LinkedIn Icon';
                } else if (socialType === 'Payment') {
                    label = 'Enter Payment URL*';
                    hintText = 'Example: https://venmo.com/yourusername';
                    modalTitle = 'Add Payment Icon';
                } else if (socialType === 'Phone') {
                    label = 'Enter Phone Number*';
                    hintText = 'Example: +1 0000000';
                    modalTitle = 'Add Phone Icon';
                } else if (socialType === 'Pinterest') {
                    label = 'Enter Pinterest URL*';
                    hintText = 'Example: https://pinterest.com/';
                    modalTitle = 'Add Pinterest Icon';
                } else if (socialType === 'Snapchat') {
                    label = 'Enter Snapchat URL*';
                    hintText = 'Example: https://www.snapchat.com/add/yourusername';
                    modalTitle = 'Add Snapchat Icon';
                } else if (socialType === 'Spotify') {
                    label = 'Enter Spotify URL*';
                    hintText = 'Example: https://open.spotify.com/artist/artistname';
                    modalTitle = 'Add Spotify Icon';
                } else if (socialType === 'Telegram') {
                    label = 'Enter Telegram URL*';
                    hintText = 'Example: https://t.me/';
                    modalTitle = 'Add Telegram Icon';
                } else if (socialType === 'X') {
                    label = 'Enter X (formerly Twitter) Handle*';
                    hintText = 'Example: https://x.com/yourxhandle';
                    modalTitle = 'Add X Icon';
                } else if (socialType === 'Youtube') {
                    label = 'Enter Youtube URL*';
                    hintText = 'Example: https://youtube.com/channel/youtubechannelurl';
                    modalTitle = 'Add Youtube Icon';
                } else if (socialType === 'WhatsApp') {
                    label = 'Enter WhatsApp Number*';
                    hintText = 'Example: 00000000000';
                    modalTitle = 'Add WhatsApp Icon';
                } 
                else {
                    label = 'Others';
                    hintText = 'Enter Other URL';
                }
                // Update the content in the modal
                $('#socialIconContent').html(`
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" name="socialType" id="socialType" placeholder="${hintText}">
                            <label for="socialType">${label}:</label>
                            <div class="form-text">${hintText}</div>
                        </div>
                        <div id="errorMessageAdd" class="text-danger"></div>
                    `).data({
                    'social': socialType
                });

                // Update the modal title
                $('#addSocialIconModalLabel').text(modalTitle);
                $('#saveSocialIcon').show();
                // Show the back button
                $('#backToIcons').show();
            }

            // Initial setup
            updateSocialIconButtons();

            // Handle Social Icon Selection
            $('#socialIconButtonGroup').on('click', '.social-icon-btn', function() {
                var socialType = $(this).data('social');
                updateSocialIconContent(socialType);

                // Add the hide class to hide the social icon buttons
                $('#socialIconButtonGroup').addClass('hide');
            });

            // Handle Back to Icons button
            $('#backToIcons').click(function() {
                $('#addSocialIconModalLabel').text('Add Icon');
                // Clear the content and show social icon buttons
                updateSocialIconButtons();
            });

            //Save Social Icon
            $('#saveSocialIcon').click(function() {
                var socialType = $('#socialIconContent').data('social');
                var socialTypeValue = $('#socialType').val().trim();

                // Validate the socialValue
                if (socialTypeValue === '') {
                    $('#errorMessageAdd').text(`Please enter a value for the ${socialType} icon.`);
                    return;
                }
                if (/\s/.test(socialTypeValue)) {
                    $('#errorMessageAdd').text('Please enter a value without any spaces.');
                    return;
                }
                // Clear error message if validation passes
                $('#errorMessageAdd').text('');

                // Build the entire social icons object
                var socialIconsData = {};
                var maxPriority = 0; // Track the maximum priority value

                $('.draggable').each(function() {
                    var socialType = $(this).find('.socialLinks').attr('id');
                    var priority = $(this).data('priority');

                    // Update the value attribute to reflect the changes
                    var value = $('#' + socialType).data('value');
                    // Add or update the new social icon
                    socialIconsData[socialType] = {
                        value: (socialType === socialTypeValue) ? socialTypeValue : value,
                        priority: priority
                    };

                    // Update the maximum priority
                    maxPriority = Math.max(maxPriority, priority);
                });

                // Add or update the new social icon
                if (!socialIconsData[socialType]) {
                    socialIconsData[socialType] = {
                        value: socialTypeValue,
                        priority: maxPriority + 1 // Set a default priority if needed
                    };
                }
                updateSocialLinksContainer(socialIconsData);

                // Perform AJAX request to save social icon
                $.ajax({
                    url: '{{ route('social.store') }}',
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        socialIconsData: socialIconsData
                    },
                    success: function(response) {
                        if (response.socialIcons) {
                            initialSocialIcons = response
                                .socialIcons; // Update initialSocialIcons
                            updateSocialLinksContainer(initialSocialIcons);
                        } else {
                            console.error('socialIcons is undefined in the response.');
                        }
                        
                        if(response.url_slug){
                            themePreviewIframe.src = '/' + response.url_slug;
                        }
                    },
                    error: function(error) {
                        console.error(error);
                    },
                    complete: function() {
                        // Clear the content and show social icon buttons
                        updateSocialIconButtons();
                        $('#addSocialIconModal').modal('hide');
                    }
                });
            });

            // Edit Icon Modal
            $(document).on('click', '.editIcon', function() {
                // Get the social type, value, and priority from the data attributes
                var socialType = $(this).find('.socialLinks').attr('id');
                var socialValue = $(this).find('.socialLinks').data('value');
                var priority = $(this).find('.socialLinks').data('priority');
                var status = $(this).find('.fa-pencil').data('status');

                // Set the initial values in the modal
                $('#editSocialIconModal #editedSocialType').text(socialType);
                $('#editSocialIconModal #editedSocialValue').val(socialValue);
                $('#editSocialIconModal #editedPriority').val(priority);
                $('#editSocialIconModal #editedStatus').val(status);

                // Show the modal
                $('#editSocialIconModal').modal('show');

            });

            // Function to update social icon
            function updateSocialIcon(data) {
                $.ajax({
                    url: '{{ route('social.update') }}',
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        ...data
                    },
                    success: function(response) {
                        if (response.socialIcons) {
                            // Update the icon container with the latest data
                            updateSocialLinksContainer(response.socialIcons);
                        } else {
                            console.error('socialIcons is undefined in the response.');
                        }
                        if(response.url_slug){
                            themePreviewIframe.src = '/' + response.url_slug;
                        }
                    },
                    error: function(error) {
                        console.error(error);
                    }
                });
            }

            // Edit actions
            $('#saveEditedSocialIcon').click(function() {
                var editedSocialType = $('#editSocialIconModal #editedSocialType').text();
                var editedSocialValue = $('#editSocialIconModal #editedSocialValue').val().trim();
                var editedPriority = $('#editSocialIconModal #editedPriority').val();
                var editedStatus = $('#editSocialIconModal #editedStatus').val();

                // Validate the editedSocialValue
                if (editedSocialValue === '') {
                    $('#errorMessageEdit').text(`Please enter a value for the ${editedSocialType} icon.`);
                    return;
                }
                // Check for spaces
                if (/\s/.test(editedSocialValue)) {
                    $('#errorMessageEdit').text('Please enter a value without any spaces.');
                    return;
                }
                $('#errorMessageEdit').text('');

                // Update the DOM with the edited values
                var editedIcon = $(
                    `.socialLinkRow[data-priority="${editedPriority}"] #${editedSocialType}`);
                editedIcon.data('value', editedSocialValue);
                editedIcon.html(
                    `${getSocialIcon(editedSocialType)}<span class="mx-3">${editedSocialType}</span>`);
                editedIcon.closest('.socialLinkCard').find('.toggle-switch').data('status', editedStatus);

                // Perform AJAX request to save social icon
                updateSocialIcon({
                    socialType: editedSocialType,
                    socialValue: editedSocialValue,
                    priority: editedPriority,
                    status: editedStatus
                });

                // Close the edit modal
                $('#editSocialIconModal').modal('hide');
            });

            // Toggle switch change event
            $(document).on('change', '.toggle-switch', function() {
                var status = $(this).prop('checked');
                var priority = $(this).closest('.socialLinkCard').data('priority');
                var socialType = $(this).closest('.socialLinkCard').find('.socialLinks').attr('id');
                var socialValue = $(this).closest('.socialLinkCard').find('.socialLinks').data('value');

                updateSocialIcon({
                    socialType: socialType,
                    socialValue: socialValue,
                    priority: priority,
                    status: status
                }, function(response) {
                    $(this).prop('checked', response.updatedStatus);
                });
            });

            //Delete Icon
            $('#removeSocialIconConfirmed').click(function() {
                var socialType = $('#editedSocialType').text();

                $.ajax({
                    url: '{{ route('social.delete') }}',
                    type: 'DELETE',
                    data: {
                        _token: '{{ csrf_token() }}',
                        socialType: socialType
                    },
                    success: function(response) {
                        if (response.socialIcons) {
                            updateSocialLinksContainer(response.socialIcons);
                        } else {
                            console.error(
                                'socialIcons is undefined in the response.');
                        }
                        
                        if(response.url_slug){
                            themePreviewIframe.src = '/' + response.url_slug;
                        }
                    },
                    error: function(error) {
                        console.error(error);
                    },
                    complete: function() {
                        // Add the class to indicate the removal
                        $(`.social-icon-btn[data-social="${socialType}"]`).addClass(
                            'social-link-removed');

                        updateSocialIconButtons();
                        // Close the confirmation modal
                        $('#confirmationModal').modal('hide');
                    }
                });
            });

            // Handle Social Links Container Delete
            $('#socialLinksContainer').on('click', '.deleteButton', function() {
                var socialType = $(this).closest('.row').find('.socialLinks').attr('id');
                // Perform AJAX request to delete social icon
                $.ajax({
                    url: '{{ route('social.delete') }}',
                    type: 'DELETE',
                    data: {
                        _token: '{{ csrf_token() }}',
                        socialType: socialType
                    },
                    success: function(response) {
                        if (response.socialIcons) {
                            updateSocialLinksContainer(response.socialIcons);
                        } else {
                            console.error('socialIcons is undefined in the response.');
                        }
                        
                        if(response.url_slug){
                            themePreviewIframe.src = '/' + response.url_slug;
                        }
                    },
                    error: function(error) {
                        console.error(error);
                    }
                });
            });

            // Function to show social icons on page load
            function showInitialSocialIcons(initialSocialIcons) {
                if (typeof initialSocialIcons === 'object' && initialSocialIcons !== null) {
                    updateSocialLinksContainer(initialSocialIcons);
                } else {
                    console.error('initialSocialIcons is undefined on page load.');
                }
            }

            // Call the function on page load
            showInitialSocialIcons(@json($socialIcons));

            function makeIconContainerDraggable() {
                var container = document.getElementById('socialLinksContainer');

                if (typeof Sortable !== 'undefined') {
                    new Sortable(container, {
                        handle: '.icon-container', // Specify the handle for dragging
                        onUpdate: function(event) {
                            // Get the updated priority order
                            var priorities = {};
                            var socialIconsData = {}; // Initialize socialIconsData

                            $('.draggable').each(function(index) {
                                var socialType = $(this).find('.socialLinks').attr('id');
                                var priority = index + 1;
                                priorities[socialType] = priority;

                                // Update the priority in the DOM
                                $(this).data('priority', priority);

                                // Build socialIconsData for dragging
                                socialIconsData[socialType] = {
                                    value: $(this).find('.socialLinks').data('value'),
                                    priority: priority
                                };
                            });
                            // Perform AJAX request to save the updated priorities
                            $.ajax({
                                url: '{{ route('social.store') }}',
                                type: 'PUT',
                                data: {
                                    _token: '{{ csrf_token() }}',
                                    // priorities: priorities
                                    socialIconsData: socialIconsData // Send socialIconsData for dragging
                                },
                                success: function(response) {
                                    if (response.socialIcons) {
                                        // Update the icon container with the latest data
                                        updateSocialLinksContainer(response.socialIcons);
                                    } else {
                                        console.error(
                                            'socialIcons is undefined in the response.');
                                    }
                                    
                                    if(response.url_slug){
                                        themePreviewIframe.src = '/' + response.url_slug;
                                    }
                                },
                                error: function(error) {
                                    console.error(error);
                                }
                            });
                        }
                    });
                } else {
                    console.error('Sortable library is not properly included or loaded.');
                }
            }
        });
    </script>
@endsection
