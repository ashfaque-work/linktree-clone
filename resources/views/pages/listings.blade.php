@extends('layouts.app')
@section('content')
    <style>
        .bg-sand {
            --tw-bg-opacity: 1;
            background-color: rgb(224 226 217 / var(--tw-bg-opacity));
        }
    </style>
    <div class="container mt-5">
        @if (session('message'))
            <div class="alert alert-danger">
                {{ session('message') }}
            </div>
        @endif
        @error('url_slug')
            <div class="alert alert-danger alert-dismissible fade show" id="alert-dismissible" role="alert">
              <strong>Error</strong> {{ $message }}
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @enderror
        <div class="row mx-auto">
            {{-- Add Link Section --}}
            <div class="col-7" style="min-width: 400px;">
                <h5>Links</h5>
                <!--<div class="card border-light-subtle rounded-4">-->
                    <!--<div class="card-body">-->
                        <div class="mb-3">
                            <button class="btn btn-dark rounded-pill w-100 my-4" data-bs-toggle="modal"
                                data-bs-target="#addLinkModal"><i class="fa fa-plus" aria-hidden="true"></i>&nbsp Add
                                link</button>
                            <!--<button class="btn btn-light mt-4 rounded-pill"> Add Header</button>-->
                        </div>
                    <!--</div>-->
                <!--</div>-->
                @if (isset($decodedData))
                    @foreach ($decodedData as $key => $value)
                        <div class="card mt-2 border-light-subtle rounded-4" id="{{ $key }}">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-75 w-75">
                                        <input class="w-100 border-0 mb-2 titleInput" type="text"
                                            data-previous-key="{{ $value->title }}" value= "{{ $value->title }}">
                                        <input class="w-100 border-0 urlInput" type="text" value="{{ $value->url }}">
                                        <input type="hidden" class="priority" value="{{ $value->priority }}">

                                    </div>
                                    <div class="col-25 w-25 d-flex justify-content-end align-items-flex">
                                        <!--<a type="button" class="btn" onclick="">-->
                                        <!--    <i class="fas fa-share-square"></i>-->
                                        <!--</a>-->
                                        <div class="form-check form-switch" data-key="{{ $key }}">
                                            <input class="form-check-input" type="checkbox" id="flexSwitchCheckChecked"
                                                {{ isset($value->visibility) ? ($value->visibility == 'true' ? 'checked' : '') : 'checked' }}>
                                        </div>
                                    </div>
                                </div>
                                <div id="messageBox" class="d-inline text-danger"></div>

                                {{-- Icon Buttons --}}
                                <div class="d-inline">
                                    <button type="button" class="btn thumbnailIcon p-0 ms-2 me-4"
                                        data-bs-toggle="collapse" data-bs-target="#collapse{{ $key }}"
                                        aria-expanded="false" aria-controls="collapse{{ $key }}" data-key="{{ $key }}">
                                        <i class="fa fa-image"></i>
                                    </button>
                                    <button type="button" class="btn deleteIcon p-0" data-bs-toggle="collapse"
                                        data-bs-target="#collapseDelete{{ $key }}" aria-expanded="false"
                                        aria-controls="collapseDelete{{ $key }}" data-key="{{ $key }}">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </div>

                                {{-- Image button expand --}}
                                <div class="collapse thumbnailDiv" id="collapse{{ $key }}">
                                    <div class="d-flex row px-3">
                                        <div class="p-1 bg-sand w-100">
                                            <div class="d-flex position-relative">
                                                <div class="text-center w-100">
                                                    <span class="fw-bold">Add Thumbnail</span>
                                                </div>
                                                <button type="button"
                                                    class="btn collapseButton position-absolute top-50 end-0 translate-middle-y rounded-circle"
                                                    data-bs-toggle="collapse" data-bs-target="#collapse{{ $key }}"
                                                    aria-expanded="false" aria-controls="collapse{{ $key }}">
                                                    <i class="fa fa-x"></i>
                                                </button>
                                            </div>
                                        </div>

                                        {{-- If there is no thumbnail image --}}
                                        <div
                                            @if (isset($value->thumbnail)) class="d-none" @else class="flex-grow-1" @endif id="withoutThumbnailDiv{{ $key }}">
                                            <div class="text-center header mt-2">
                                                {{-- <img class="thumbnailUploaded d-flex" src="" alt=""> --}}
                                                <h6 class="modal-title fw-normal" id="uploadImageModalLabel">Add a Thumbnail
                                                    or Icon to this Link.
                                                </h6>
                                            </div>
                                            <button type="button" class="btn btn-dark rounded-pill w-100 my-2 fw-bold"
                                                data-bs-toggle="modal"
                                                data-bs-target="#uploadThumbnailModal{{ $key }}">Set
                                                Thumbnail</button>
                                        </div>

                                        {{-- If there is a thumbnail image --}}
                                        <div
                                            @if (!isset($value->thumbnail)) class="d-none" @else class="d-flex withThumbnailDiv" @endif id="withThumbnailDiv{{ $key }}">
                                            <div class="w-25 mt-2">
                                                <img class="thumbnailUploaded"
                                                    @if (isset($value->thumbnail)) src="{{ url('storage/') . '/' . $value->thumbnail }}" @endif
                                                    alt=""
                                                    style="
                                                        width: 100px;
                                                        height: 100px;
                                                        border-radius: 5px;
                                                        margin-left: 5px;
                                                    ">
                                            </div>
                                            <div class="w-75 mt-2">
                                                <button type="button" class="btn btn-dark rounded-pill w-100 my-2 fw-bold changeThumbnailButton"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#uploadThumbnailModal{{ $key }}">Change</button>
                                                <button type="button" class="btn btn-light rounded-pill w-100 my-2 fw-bold removeThumbnailButton" data-key="{{ $key }}">Remove</button>
                                            </div>
                                        </div>

                                        {{-- Upload Image Modal --}}
                                        <div class="modal fade" id="uploadThumbnailModal{{ $key }}" tabindex="-1"
                                            aria-labelledby="uploadImageModalLabel{{ $key }}" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title"
                                                            id="uploadImageModalLabel{{ $key }}">Upload Thumbnail
                                                            Image
                                                        </h5>   
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form class="uploadThumbnailForm" id="uploadThumbnailForm{{ $key }}" enctype="multipart/form-data">
                                                            @csrf
                                                            <input type="file" name="thumbnail" class="form-control"
                                                                accept=".jpg, .jpeg, .png, .heic">
                                                            <input type="hidden" name="key"
                                                                value="{{ $key }}">
                                                            <input type="hidden" name="id"
                                                                value="{{ $id }}">
                                                            <button type="button"
                                                                class="btn btn-dark mt-3 uploadThumbnailButton" data-key="{{ $key }}">Upload</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- Delete button expand --}}
                                <div class="collapse deleteDiv" id="collapseDelete{{ $key }}">
                                    <div class="d-flex row px-3">
                                        <div class="p-1 bg-sand w-100">
                                            <div class="d-flex position-relative">
                                                <div class="text-center w-100">
                                                    <span class="fw-bold">Delete</span>
                                                </div>
                                                <button type="button"
                                                    class="btn collapseButton position-absolute top-50 end-0 translate-middle-y rounded-circle"
                                                    data-bs-toggle="collapse"
                                                    data-bs-target="#collapseDelete{{ $key }}"
                                                    aria-expanded="false"
                                                    aria-controls="collapseDelete{{ $key }}">
                                                    <i class="fa fa-x"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="flex-grow-1">
                                            <div class="text-center header mt-2">
                                                <h6 class="modal-title fw-normal" id="uploadImageModalLabel">Delete this
                                                    forever?
                                                </h6>
                                            </div>
                                            <div class="d-flex">
                                                <button type="button"
                                                    class="btn btn-light rounded-pill w-50 my-2 mx-2 fw-bold"
                                                    data-bs-toggle="collapse"
                                                    data-bs-target="#collapseDelete{{ $key }}"
                                                    aria-expanded="false"
                                                    aria-controls="collapseDelete{{ $key }}">Cancel</button>
                                                <button type="button"
                                                    class="deleteButton btn btn-dark rounded-pill w-50 my-2 mx-2 fw-bold" data-key="{{ $key }}">Delete</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>

            {{-- Preview Section --}}
            <div class="col-5" style="min-width: 400px;">
                <h5>Preview</h5>
                <div class="d-flex justify-content-center align-items-center">
                    <iframe src="{{ url($url_slug) }}" scrolling="yes" id="theme-preview-iframe" width="270px"
                        height="520px" style="border:10px solid black; border-radius:35px;">
                    </iframe>
                </div>
            </div>
        </div>
    </div>


    <!-- Modal -->
    <div class="modal fade" id="addLinkModal" tabindex="-1" aria-labelledby="addLinkModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addLinkModalLabel">Add Link</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('createListing') }}" method="post" name="createList">
                        @csrf
                        <div class="mb-3">
                            <label for="title" class="form-label">Title:</label>
                            <input type="text" class="form-control" id="title" name="title" required>
                        </div>
                        <div class="mb-3">
                            <label for="url" class="form-label">URL:</label>
                            <input type="url" class="form-control" id="url" name="url" value="https://"
                                required>
                        </div>
                        <input type="hidden" class="form-control" id="id" name="id" value="{{$id}}">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-dark">Add</button>
                </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        const titleInputs = document.getElementsByClassName('titleInput');
        const urlInputs = document.getElementsByClassName('urlInput');
        const priority = document.getElementsByClassName('priority');
        const formSwitches = document.getElementsByClassName('form-switch');
        const deleteButton = document.getElementsByClassName('deleteButton');
        const themePreviewIframe = document.getElementById('theme-preview-iframe');
        const uploadThumbnailForm = document.getElementsByClassName('uploadThumbnailForm');
        const uploadThumbnailButton = document.getElementsByClassName('uploadThumbnailButton');
        const removeThumbnailButton = document.getElementsByClassName('removeThumbnailButton');
        const thumbnailIcon = document.getElementsByClassName('thumbnailIcon');
        const deleteIcon = document.getElementsByClassName('deleteIcon');
    
        themePreviewIframe.addEventListener('load', function () {
            preventModalClick();
        });
        // Attach change event to each titleInput and urlInput
        for (let i = 0; i < titleInputs.length; i++) {
            titleInputs[i].addEventListener('change', function() {
                updateData(i);
            });
            urlInputs[i].addEventListener('change', function() {
                updateData(i);
            });
            formSwitches[i].addEventListener('click', function() {
                linkVisibility(i);
            });
            deleteButton[i].addEventListener('click', function() {
                const key = $(this).data('key');
                deleteData(key);
            });
            uploadThumbnailButton[i].addEventListener('click', function() {
                uploadThumbnail(i);
            });
            removeThumbnailButton[i].addEventListener('click', function() {
                const key = $(this).data('key');
                removeThumbnail(key);
            });
            thumbnailIcon[i].addEventListener('click', function() {
                const key = $(this).data('key');
                const id = `collapseDelete${key}`;
                collapseHide(id);
            });
            deleteIcon[i].addEventListener('click', function() {
                const key = $(this).data('key');
                const id = `collapse${key}`;
                collapseHide(id);
            });
        }

        // Update link and title with other related data
        function updateData(index) {
            const data = {};
            var previousTitle = "";
            var thumbnailUrl;

            // Loop through each pair of titleInput and urlInput
            $('.titleInput').each(function(index) {
                const titleInput = $(this);
                const title = titleInput.val();
                const parentDiv = titleInput.closest('.card');
                const key = parentDiv.attr('id');
                const imageSrc = parentDiv.find('img.thumbnailUploaded').attr('src');
                if (imageSrc) {
                    thumbnailUrl = imageSrc.split('/storage/')[1];
                } else {
                    thumbnailUrl = "";
                }
                previousTitle = titleInput.data('previous-key');
                const url = $('.urlInput').eq(index).val();
                const priority = $('.priority').eq(index).val();

                // Update data-key for the corresponding form-switch div
                const formSwitch = $('.form-switch').eq(index);
                const visibility = formSwitch.find('.form-check-input').prop('checked');
                formSwitch.attr('data-key', key);


                // Add key and url to the data array
                data[key] = {
                    title: title,
                    url: url,
                    visibility: visibility,
                    thumbnail: thumbnailUrl,
                    priority:priority,
                };
            });

            // Send AJAX request
            $.ajax({
                url: '{{ route('updateListing') }}',
                type: 'POST',
                data: JSON.stringify({
                    _token: '{{ csrf_token() }}',
                    list: data,
                    id: {{$id}},
                    previousTitle: previousTitle
                }),
                contentType: 'application/json',
                success: function(response) {
                    console.log('Data updated successfully');
                    // handle the success response as needed

                    if (response.url_slug) {
                        themePreviewIframe.src = "{{ url('') }}" + '/' + response.url_slug;
                    }
                },
                error: function(error) {
                    console.error('Error updating data:', error);
                    // handle the error as needed
                }
            });
        }

        // Show or hide link
        function linkVisibility(index) {
            const checkbox = formSwitches[index].querySelector('.form-check-input');
            const key = formSwitches[index].getAttribute('data-key');

            // Check the state of the checkbox and toggle link visibility accordingly
            // Send AJAX request
            $.ajax({
                url: '{{ route('links.visibility') }}',
                type: 'POST',
                data: JSON.stringify({
                    _token: '{{ csrf_token() }}',
                    key: key,
                    id: {{$id}}
                }),
                contentType: 'application/json',
                success: function(response) {
                    console.log('Visiblity updated successfully');

                    if (response.url_slug) {
                        themePreviewIframe.src = "{{ url('') }}" + '/' + response.url_slug;
                    }
                },
                error: function(error) {
                    console.error('Error updating data:', error);
                }
            });
        }

        // delete link
        function deleteData(key) {
            console.log(key);
            const parentDiv = document.getElementById(key);
            $.ajax({
                url: '{{ route('deleteListing') }}',
                type: 'POST',
                data: JSON.stringify({
                    _token: '{{ csrf_token() }}',
                    key: key,
                    id: {{$id}}
                }),
                contentType: 'application/json',
                success: function(response) {
                    console.log('Item deleted successfully');
                    // You can handle the success response as needed
                    parentDiv.parentNode.removeChild(parentDiv);
                    if (response.url_slug) {
                        themePreviewIframe.src = "{{ url('') }}" + '/' + response.url_slug;
                    }
                },
                error: function(error) {
                    console.error('Error deleting item:', error);
                    // You can handle the error as needed
                }
            });
        }

        // upload thumbnail for links
        function uploadThumbnail(index) {
            const formData = new FormData(uploadThumbnailForm[index]);
            const key = formData.get('key');

            $.ajax({
                url: '{{ route('links.uploadThumbnail') }}',
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    console.log('Thumbnail uploaded successfully');

                    const withoutThumbnailDiv = document.getElementById(`withoutThumbnailDiv${key}`);
                    withoutThumbnailDiv.classList.add('d-none');

                    const withThumbnailDiv = document.getElementById(`withThumbnailDiv${key}`);
                    withThumbnailDiv.classList.remove('d-none');
                    withThumbnailDiv.classList.add('d-flex');
                    const thumbnailImage = withThumbnailDiv.querySelector('.thumbnailUploaded');

                    // If the image exists, create and append the img tag
                    if (response.thumbnailUrl) {
                        thumbnailImage.src = '{{ url('storage/') }}' + '/' + response.thumbnailUrl;
                    }
                    if (response.url_slug) {
                        themePreviewIframe.src = "{{ url('') }}" + '/' + response.url_slug;
                    }

                    $(`#uploadThumbnailModal${key}`).modal('hide'); // Close the modal
                },
                error: function(error) {
                    console.error('Error uploading profile image', error);
                }
            });
        }

        // remove thumbnail from links
        function removeThumbnail(key){
            console.log(key);
            const withoutThumbnailDiv = document.getElementById(`withoutThumbnailDiv${key}`);
            const withThumbnailDiv = document.getElementById(`withThumbnailDiv${key}`);
            $.ajax({
                url: '{{ route('links.removeThumbnail') }}',
                type: 'POST',
                data: JSON.stringify({
                    _token: '{{ csrf_token() }}',
                    key: key,
                    id: {{$id}}
                }),
                contentType: 'application/json',
                success: function(response) {
                    console.log('Thumbnail removed successfully');

                    withoutThumbnailDiv.classList.remove('d-none');

                    withThumbnailDiv.classList.remove('d-flex');
                    withThumbnailDiv.classList.add('d-none');

                    if (response.url_slug) {
                        themePreviewIframe.src = "{{ url('') }}" + '/' + response.url_slug;
                    }

                    $(`#uploadThumbnailModal${key}`).modal('hide'); // Close the modal
                },
                error: function(error) {
                    console.error('Error uploading profile image', error);
                }
            });
        }
        // for hiding the collapse div
        function collapseHide(id) {
            const targetElement = document.getElementById(id);
            if (targetElement && targetElement.classList.contains('show')) {
                $(targetElement).collapse('toggle');
            }
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
    </script>
@endsection
