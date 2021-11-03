<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use DB;

class ProductController extends Controller
{
  public function index()
  {
    return view('products');
  }
  public function store()
  {
    $validator = \Validator::make(request()->all(), [
      'product_name' => 'required|max:220|string|unique:products,product_name',
      'product_image' => 'required|image|mimes:jpg,png,svg,jpeg',
      'product_description' => 'required|max:550',
    ]);

    if (!$validator->passes()) {
      return response()->json(['code' => 0, 'error' => $validator->errors()->toArray()]);
    } else {
      $path = 'products/';
      $file = request()->file('product_image');

      $file_name = time() . '_' . $file->getClientOriginalName();
      // $upload = $file->storeAs($path, $file_name);
      $upload = $file->storeAs($path, $file_name, 'public');
      if ($upload) {

        $inserted = Product::insert([
          'product_name' => request('product_name'),
          'product_brand' => $file_name,
          'product_description' => request('product_description'),
        ]);

        if ($inserted) {
          return response()->json(['code' => 1, "message" => 'New product has been uploaded successfully']);
        } else {
          return response()->json(['code' => 1, "message" => 'Something went wrong, Please try again']);
        }
      }
    }
  }

  public function fetch()
  {
    // $products = Product::all()->sortByDesc('created_at');
    $products = DB::table('products')->paginate(5);
    // return view('products', $products);
    // $data = \View::make('products-table', ['products', $products])->render();
    $data = \View::make('products-table')->with('products', $products)->render();
    return response()->json(['code' => 1, 'result' => $data]);

  }

  function getProductsDetails() {
   $product = Product::find(request()->product_id);
    return response()->json(['code' => 1, 'result' => $product]);
  }
}
