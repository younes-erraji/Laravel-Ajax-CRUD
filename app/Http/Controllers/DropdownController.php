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

      $cities = City::where('country_code', request()->code)->get();
      if (count($cities) > 0) {
        return response()->json(['code' => 1, 'cities' => $cities]);
      } else {
        return response()->json(['code' => 0, 'message' => "There's no data to show"]);
      }
    }
}
