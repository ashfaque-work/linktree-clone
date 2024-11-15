<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Add New Profile Link</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
            <form action="{{ route('store.profile') }}" method="post">
                @csrf
                <div class="mb-3">
                  <label for="url_slug" class="form-label">URL Slug</label>
                  <input type="text" class="form-control  @error('name') is-invalid @enderror" name="url_slug" id="url_slug" placeholder="URL Slug" required>
                  @error('url_slug')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
                </div>
                <div class="mb-3">
                  <label for="profile_title" class="form-label">Profile Title</label>
                  <input type="text" class="form-control" name="profile_title" id="profile_title" placeholder="Profile Title">
                </div>
                <button type="submit" class="btn btn-primary">{{ isset($appearance) ? 'Update' : 'Create' }}</button>
            </form>
      </div>
    </div>
  </div>
</div>