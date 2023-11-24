<div class="modal fade" id="modalId" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body text-start">
                @foreach ($product->productAttributes as $productAttribute)
                    <div class="mb-3">
                        <h6>Color</h6>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="color"
                                value="{{ $productAttribute?->color?->name }}" checked>
                            <label class="form-check-label" for="color">{{ $productAttribute?->color->name }}</label>
                        </div>
                    </div>
                    <div class="mb-3">
                        <h6>Size</h6>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="size"
                                value="{{ $productAttribute?->size->value }}" checked>
                            <label class="form-check-label" for="size">{{ $productAttribute?->size->value }}</label>
                        </div>
                    </div>
                    <div class="mb-3">
                        <h6>Material</h6>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="material" id="material"
                                value="{{ $productAttribute?->material->name }}" checked>
                            <label class="form-check-label"
                                for="material">{{ $productAttribute?->material->name }}</label>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="mb-3">
                            <label for="quantity" class="form-label">Quantity</label>
                            <input type="number" name="quantity" value="1" id="quantity" class="form-control rounded-pill"
                                placeholder="Enter quantity">
                        </div>
                    </div>
                    <div id="errors" class="text-danger"></div>
                @endforeach
                <div class="d-flex justify-content-center gap-3">
                    <button type="button" class="btn btn-secondary col-6 rounded-pill font-poppins pt-2 pb-2" data-bs-dismiss="modal" aria-label="Close">Cancel</button>
                    <button type="button" class="ModalBtn btn bg-purple text-white col-6 rounded-pill font-poppins pt-2 pb-2" onclick="addToCart('{{ $product->id }}')">Add To
                        Cart</button>
                </div>
            </div>
        </div>
    </div>
</div>
