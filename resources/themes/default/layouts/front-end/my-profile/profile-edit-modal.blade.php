<div class="modal fade" id="profileModalId" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" role="dialog"
    aria-labelledby="modalTitleId" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitleId">Edit profile</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="">
                    <form class="MyProfileForm font-poppins" action="{{ route('customer.update-profile-detail') }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                            <input type="text" id="name" name="name" placeholder="Enter your name *" required
                            value="">
                            @error('name')
                                <div class="text-danger"></div>
                            @enderror
                            {{-- <br>
                            <input type="email" id="email" name="email" placeholder="Enter your email *" required
                                value="">
                            @error('email')
                                <div class="text-danger"></div>
                            @enderror --}}
                            <br>
                            <input type="file" id="avatar" name="avatar">
                            @error('avatar')
                                <div class="text-danger"></div>
                            @enderror
                            <br>
                            <input type="date" id="date_of_birth" name="date_of_birth" required value="">
                            @error('date_of_birth')
                                <div class="text-danger"></div>
                            @enderror
                            <br>
                            <div class="form-group d-flex justify-content-center">
                                <button class="rounded-pill text-white w-100" type="submit">Update</button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
