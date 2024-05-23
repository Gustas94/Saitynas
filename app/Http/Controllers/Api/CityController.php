<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cities;
use Illuminate\Http\Request;

class CityController extends Controller
{
    public function index(Request $request)
    {
        $country_id = $request->query('country_id');

        if (!$country_id) {
            return response()->json([]);
        }

        $cities = Cities::where('country_id', $country_id)->get();
        return response()->json($cities);
    }
}
