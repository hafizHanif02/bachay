<div class="modal fade" id="childModalId" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" role="dialog"
    aria-labelledby="modalTitleId" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitleId">Add New child</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="">
                    <form class="MyProfileForm font-poppins" action="#"
                        method="POST">
                        @csrf
                        <input type="email" id="with_email" name="with_email" placeholder="Email of child *" required
                            value="{{ old('with_email') }}">
                        @error('with_email')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                        <br>
                        <select id="relation" name="relation" required>
                            <option value="" selected disabled>Select relation</option>
                            <option value="father">Father</option>
                            <option value="mother">Mother</option>
                            <option value="guardian">Guardian</option>
                        </select>
                        @error('relation')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                        <div class="form-group">
                            <button class="rounded-pill text-white" type="submit">Save</button>
                            <button class="rounded-pill fw-semibold" type="button">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
