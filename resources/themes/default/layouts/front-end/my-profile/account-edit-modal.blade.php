<div class="modal fade" id="emailEditModalId" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Acocunt edit</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="updateForm">
                    <div class="mb-3">
                        <label for="inputEmail" class="form-label">Email address</label>
                        <input type="email" class="form-control rounded-pill" id="inputEmail" name="email"
                            placeholder="name@example.com" required>
                    </div>
                    <div class="mb-3">
                        <label for="inputPhone" class="form-label">Phone number</label>
                        <input type="tel" class="form-control rounded-pill" id="inputPhone" name="phone"
                            placeholder="123-456-7890" required>
                    </div>
                    <button type="submit" class="btn w-100 rounded-pill bg-purple text-light">Update</button>
                </form>
            </div>
        </div>
    </div>
</div>
<style>
    .bg-purple{
        background-color: #8b5bc0;
    }
</style>
