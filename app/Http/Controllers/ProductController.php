<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

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
    ], [
      'product_name.required' => 'Product name is required',
      'product_image.required' => 'Product name is required',
      'product_description.required' => 'Product name is required',

      'product_name.string' => 'Product name must be a string',

      'product_name.unique' => 'This product name is already exists',

      'product_image.image' => 'Product image must be an image',

      'product_image.mimes' => 'Product image must be a file of type: jpg, png, svg, jpeg.',

      'product_name.max' => 'Product name must not be greater than 220.',
      'product_description.max' => 'Product description must not be greater than 550.',
    ]);

    // dd($validator->passes());
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
    $products = Product::all()->sortByDesc('created_at');
    return view('product', $products);
  }
}
