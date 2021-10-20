<!DOCTYPE html>
<html lang="en">

  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>Laravel CRUD Operation with Ajax</title>
    <link rel="stylesheet" href="{{ asset('bootstrap.min.css') }}" />
    <style>
      .image-fluid {
        max-width: 100%;
        max-height: 140px;
        object-fit: cover;
        object-position: center;
        margin-bottom: 10px
      }
    </style>
  </head>

  <body>
    <div class="container">

      <div class="row mt-lg-4">
        <div class="col-md-6">
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
                  <label for="product_image" class="mb-1">product name</label>
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

    <script src="{{ asset('jquery.min.js') }}"></script>
    <script>
      $(function () {
        $('#main-form').on('submit', function (e) {
          e.preventDefault();
          // alert('test');

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
                alert(data.message);
              }
            }
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
                console.log(e.target.result);
                $('<img />', { 'src': e.target.result, 'class': 'image-fluid' }).appendTo(image_holder);
              }
              image_holder.show();
              reader.readAsDataURL($(this)[0].files[0]);
            } else {
              image_holder.text('This Browser does not support FileReader');
            }
          } else {
            $(image_holder).empty();
          }
        });

        (function fetchProducts () {
          $.get('{{ url('fetch') }}', {}, function (data) {
            $('#products').html(data.result);
          }, 'json')
        })();
      });
    </script>
  </body>

</html>
