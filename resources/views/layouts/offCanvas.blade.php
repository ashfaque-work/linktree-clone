<div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasExample" aria-labelledby="offcanvasExampleLabel">
  <div class="offcanvas-header">
    <h5 class="offcanvas-title" id="offcanvasExampleLabel">Profiles</h5>
    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
  </div>
  <div class="offcanvas-body">
    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header">
                    <button type="button" class="btn btn-dark float-end" data-bs-toggle="modal" data-bs-target="#exampleModal">
                      <i class="fa-solid fa-plus"></i> Add Profile
                    </button>
                </div>
                <div class="card-body"> 
                    <p>Switch to another profile by clicking below profile options.</p>
                    <ul class="list-group">
                        @foreach ($user->appearances as $appearance)
                                <a href="{{ route('change.profile', ['profileId' => $appearance->id]) }}">
                                    <li class="list-group-item @if($appearance->id == session('current_profile_id')) active @endif">
                                    {{ $appearance->url_slug }} <i class="fa-solid fa-arrow-right float-end"></i>
                                    </li>
                                </a>
                        @endforeach
                    </ul>
                </div>
            </div>                  
        </div>
    </div>
  </div>
</div>