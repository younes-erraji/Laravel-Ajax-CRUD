<div class="modal fade" id="editProduct" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Modal title</h5>
        <button type="button" class="close btn btn-danger btn-sm" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="update-form" action="{{ route('save-product') }}" method="POST" enctype="multipart/form-data">
          @csrf
          <input type="hidden" name="product_id" value="" />
          <div class="form-group mb-3">
            <label for="product_name" class="mb-1">product name</label>
            <input type="text" id="product_name" name="product_name" class="form-control"
              placeholder="enter product name" />
            <span class="product_name_error text-danger error-text"></span>
          </div>
          <div class="form-group mb-3">
            <label for="product_image_update" class="mb-1">product brand <button type="button" id="clearInputFile" class="btn btn-warning btn-sm">clear</button></label>
            <input type="file" id="product_image_update" name="product_image_update" class="form-control" />
            <span class="product_image_update_error text-danger error-text"></span>
          </div>
          <div class="image-holder-update text-center"></div>
          <div class="form-group mb-3">
            <label for="product_description" class="mb-1">product description</label>
            <textarea id="product_description" name="product_description" class="form-control"></textarea>
            <span class="product_description_error text-danger error-text"></span>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary" form="update-form">Save</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
