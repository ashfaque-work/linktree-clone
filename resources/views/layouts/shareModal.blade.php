 <div class="modal fade" id="shareModal" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-end">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title mt-0" id="modalLabel">Share your LinkHive</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="card mb-2 w-100">
                        <button type="button" class="btn p-1 w-100" data-bs-toggle="modal"
                            data-bs-target="#qrModal">
                            <div class="d-flex align-items-center justify-content-between p-3 btn-modal">
                                <div class="d-flex align-items-center">
                                    <div class="p-2" style="background:pink; border-radius:6px;">
                                        <i class="fa fa-qrcode" aria-hidden="true"></i>
                                    </div>
                                    <p class="m-0 px-2" style="font-size:15px;">My LinkHive QR Code</p>
                                </div>
                                <i class="fas fa-chevron-right"></i>
                            </div>
                        </button>
                    </div>

                    <div class="card mb-2 w-100">
                        @if($user->appearances && $user->appearances->isNotEmpty())
                            <?php $appearance = $user->appearances->first(); ?>
                            <a href="{{ url($appearance ? $appearance->url_slug : $user->name) }}"
                                class="btn p-1 w-100" target="_blank" id="openMyLink">
                                <div class="d-flex align-items-center justify-content-between p-3 ">
                                    <div class="d-flex align-items-center">
                                        <div class="p-2" style="background:rgb(159, 217, 50); border-radius:6px;">
                                            <i class="fa-solid fa-globe" aria-hidden="true"></i>
                                        </div>
                                        <p class="m-0 px-2" style="font-size:15px;">Open my LinkHive</p>
                                    </div>
                                    <i class="fas fa-chevron-right"></i>
                                </div>
                            </a>
                        @endif
                    </div>

                    <div class="card mb-2 w-100">
                        <div class="d-flex align-items-center justify-content-between p-3 btn-modal">
                            @if($user->appearances && $user->appearances->isNotEmpty())
                                <?php $appearance = $user->appearances->first(); ?>
                                <input class="form-control" type="text" id="link"
                                    value="{{ url( $appearance->url_slug) }}"
                                    style="border:0; text-align:center;">
                                <button class="btn btn-secondary" onclick="myFunction(this)">Copy</button>
                            @endif
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    
    <div class="modal fade" id="qrModal" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-end">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btn" data-bs-toggle="modal" data-bs-target="#shareModal" style="margin-right: 15px; padding-top:9px;">
                        <i class="fa-solid fa-less-than"></i>
                    </button>
                    <h5 class="modal-title mt-0" id="modalLabel">QR Code</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="card mb-2 w-100">
                        @if($user->appearances && $user->appearances->isNotEmpty())
                            <?php $appearance = $user->appearances->first(); ?>
                            <!--Generating qr code are-->
                            <div class="p-2 d-flex justify-content-center">
                                <img id="qrCodeImage" src="{{ $appearance->qr_image ? url('storage/' . $appearance->qr_image) : '' }}" alt="QR Code">
                            </div>
                            <div class="p-2 d-flex justify-content-center">
                                <p id="profile_link" style="font-size:15px;"></p>
                            </div>
                            <a id="downloadPNG" download="{{$appearance && $appearance->url_slug? $appearance->url_slug . '.png':'qr_code.png'}}" class="btn">
                                <div class="row no-gutters p-2 qr-btn" style="display: flex; align-items: center;">
                                    <div class="col-12 col-sm-6 col-md-8" style="flex: 1;">Download PNG</div>
                                    <div class="col-6 col-md-4" style="flex: 0 0 auto;">.PNG <i class="fa fa-download text-concrete text-xs ml-2" aria-hidden="true"></i></div>
                                </div>
    
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>