<?php

namespace App\Http\Controllers;

use App\Models\City;
use Illuminate\Http\Request;
use App\Models\Country;

class DropdownController extends Controller
{
    public function index() {
      $countries = Country::all()->sortByDesc('name');

      return view('dropdown', ['countries' => $countries]);
    }

    public function getCities() {
      $country_code = request()->country_code;

      $cities = City::where('country_code', $country_code)->get();
      return response()->json(['code' => 1, 'cities' => $cities]);
    }
}
