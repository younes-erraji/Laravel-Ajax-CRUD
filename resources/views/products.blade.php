@extends('layouts.master')
@section('styles')
<link rel="stylesheet" href="	https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.3/css/font-awesome.min.css" />
    <style>
      .image-fluid {
        max-width: 100%;
        max-height: 140px;
        object-fit: cover;
        object-position: center;
        margin-bottom: 10px
      }
    </style>
@endsection
@section('content')
    <div class="container mt-4 mb-4">

      <div class="row mt-lg-4">
        <div class="col-md-6 mb-2">
          <div class="card">
            <div class="card-header bg-primary text-white pt-3 pb-3">add new product</div>
            <div class="card-body">
              <form id="main-form" action="{{ route('save-product') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group mb-3">
                  <label for="product_name" class="mb-1">product name</label>
                  <input type="text" id="product_name" name="product_name" class="form-control"
                    placeholder="enter product name" />
                  <span class="product_name_error text-danger error-text"></span>
                </div>
                <div class="form-group mb-3">
                  <label for="product_image" class="mb-1">product brand</label>
                  <input type="file" id="product_image" name="product_image" class="form-control" />
                  <span class="product_image_error text-danger error-text"></span>
                </div>

                <div class="image-holder text-center">
                </div>

                <div class="form-group mb-3">
                  <label for="product_description" class="mb-1">product description</label>
                  <textarea id="product_description" name="product_description" class="form-control"></textarea>
                  <span class="product_description_error text-danger error-text"></span>
                </div>
                <button class="btn btn-primary">save product</button>
              </form>
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="card">
            <div class="card-header bg-primary text-white pt-3 pb-3">products</div>
            <div class="card-body" id='products'>



            </div>
          </div>
        </div>
      </div>
    </div>
@include('edit-product')
@endsection
@section('scripts')
    <script src="{{ asset('jquery.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
      $(function () {
        $('#main-form').on('submit', function (e) {
          e.preventDefault();

          var form = this;
          $.ajax({
            url: $(form).attr('action'),
            method: $(form).attr('method'),
            data: new FormData(form),
            processData: false,
            dataType: 'json',
            contentType: false,
            beforeSend: function () {
              $(form).find('span.error-text').text('');
            },
            success: function (data) {
              if (data.code == 0) {
                $.each(data.error, function (prefix, val) {
                  $(form).find('span.' + prefix + '_error').text(val[0]);
                });
              } else {
                $(form)[0].reset();
                fetchProducts();
                alert(data.message);
              }
            },

          });
        });

        $('input[type="file"][name="product_image"]').val('');
        $('input[type="file"][name="product_image"]').on('change', function () {
          var image_path = $(this)[0].value,
          image_holder = $('.image-holder'),
          extension = image_path.substring(image_path.lastIndexOf('.') + 1).toLowerCase();

          if (extension === 'jpg' || extension === 'jpeg' || extension === 'png' || extension === 'svg') {
            if (typeof FileReader !== 'undefined') {
              image_holder.empty();
              var reader = new FileReader();
              reader.onload = function (e) {
                $('<img />', { 'src': e.target.result, 'class': 'image-fluid' }).appendTo(image_holder);
              }
              image_holder.show();
              reader.readAsDataURL($(this)[0].files[0]);
            } else {
              image_holder.text('This Browser does not support FileReader');
            }
          } else {
            image_holder.empty();
          }
        });

        function fetchProducts () {
          $.get('{{ route('fetch') }}', {}, function (data) {
            $('#products').html(data.result);
          }, 'json');
        }

        fetchProducts ();

        $(document).on('click', '.edit-button', function () {
          var dataId = $(this).data('id'),
            url = "{{ route('getProductsDetails') }}";
          $.get(url, { product_id: dataId }, function (data) {

            var edit_modal = $('#editProduct');
            $(edit_modal).modal('show');

            $(edit_modal).find('form').find('input[name="product_id"]').val(data.result.id);
            $(edit_modal).find('form').find('input[name="product_name_update"]').val(data.result.product_name);
            //
            $(edit_modal).find('form').find('.image-holder-update').html('<img src="/storage/products/' + data.result.product_brand + '" class="image-fluid" />');
            $(edit_modal).find('form').find('textarea[name="product_description_update"]').text(data.result.product_description);

            $(edit_modal).find('form').find('input[name="product_image_update"]').attr('data-value', '<img src="/storage/products/' + data.result.product_brand + '" class="image-fluid" />');
            $(edit_modal).find('form').find('input[name="product_image_update"]').val('');

            $(edit_modal).find('form').find('span.error-text').text('');
          }, 'json');
        });

        $('input[type="file"][name="product_image_update"]').on('change', function () {
          var img_path = $(this)[0].value,
            img_holder = $('.image-holder-update'),
            currentImagePath = $(this).data('value'),
            extension = img_path.substring(img_path.lastIndexOf('.') + 1).toLowerCase();

          if (extension === 'jpg' || extension === 'jpeg' || extension === 'png') {
            if (typeof FileReader !== 'undefined') {
              img_holder.empty();
              var reader = new FileReader();
              reader.onload = function (e) {
                $('<img />', { 'src': e.target.result, 'class': 'image-fluid' }).appendTo(img_holder);
              }
              img_holder.show();
              reader.readAsDataURL($(this)[0].files[0]);
            } else {
              img_holder.text('This Browser does not support FileReader');
            }
          }
        });

        $(document).on('click', '#clearInputFile', function () {
          var form = $(this).closest('form');

          $(form).find('input[type="file"]').val('');
          $(form).find('.image-holder-update').html($(form).find('input[type="file"]').data('value'));
        });
        /*
        */
        $('#update-form').on('submit', function (e) {
          e.preventDefault();

          var form = this;
          $.ajax({
            url: $(form).attr('action'),
            method: $(form).attr('method'),
            data: new FormData(form),
            processData: false,
            dataType: 'json',
            contentType: false,
            beforeSend: function () {
              $(form).find('span.error-text').text('');
            },
            success: function (data) {
              console.log('success');
              if (data.code == 0) {
                $.each(data.error, function (prefix, val) {
                  $(form).find('span.' + prefix + '_error').text(val[0]);
                });
              } else {
                alert(data.message);
                fetchProducts();
                $('#editProduct').modal('hide');
                $(form)[0].reset();
              }
            },
            error: function(xhr, status, error) {
              console.log(error);
            },
            complete: function(xhr, status) {
              console.log(`Complete`);
            }
          });
        });

        // $.ajaxSetup({
        //     headers: {
        //         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        //     }
        // });

        $(document).on('click', '.delete-button', function () {
          var dataId = $(this).data('id'),
            url = "{{ route('deleteProduct') }}";
            if (confirm ('Are You sure You wanna Delete this product')) {
              $.ajax({
                headers: {
                  'X-CSRF-TOKEN': csrf
                },
                url: url,
                method: 'POST',
                data: {
                  product_id: dataId,
                },
                dataType: 'json',
                success: function (data) {
                  if (data.code == 1) {
                    fetchProducts();
                  } else {
                    alert(data.msg);
                  }

                }
              });
            }
        });

      });
    </script>
@endsection
