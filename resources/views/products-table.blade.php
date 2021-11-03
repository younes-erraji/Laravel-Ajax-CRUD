<table class="table table-hover table-striped">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Name</th>
      <th scope="col">Brand</th>
      <th scope="col">Description</th>
      <th></th>
      <th></th>
    </tr>
  </thead>
  <tbody>
    @forelse ($products as $product)
    <tr>
      <th scope="row">{{ $product->id }}</th>
      <td>{{ $product->product_name }}</td>
      <td><img src="{{ '/storage/products/' . $product->product_brand }}" width="40" alt=""></td>
      <td>{{ $product->product_description }}</td>
      <td><button href="" data-id="{{ $product->id }}" class="btn btn-success edit-button"><i class="fa fa-pencil fa-fw"></i></button></td>
      <td><button href="" data-id="{{ $product->id }}" class="btn btn-danger delete-button"><i class="fa fa-trash fa-fw"></i></button></td>
    </tr>
    @empty
    <tr>
      <th colspan="4" class="text-center">There's no data to show</th>
    </tr>
    @endforelse
  </tbody>
</table>
{{-- {!! $products->links() !!} --}}
{{-- {{ $products->onEachSide(5)->links() }} --}}
