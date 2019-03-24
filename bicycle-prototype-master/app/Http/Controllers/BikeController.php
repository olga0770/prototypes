<?php

namespace App\Http\Controllers;

use App\Bike;
use Illuminate\Http\Request;

class BikeController extends Controller
{
    public function get_home_api()
    {
        $data = $this->get_bike_summaries();
        return response()->json($data);
    }

    private function get_bike_summaries()
    {
        $collection = Bike::all([
            'id', 'serial_number', 'category', 'size', 'rented_out'
        ]);
        return collect(['bikes' => $collection->toArray()]);
    }

    public function get_home_web(Request $request)
    {
        $data = $this->get_bike_summaries();
        $data = $this->add_meta_data($data, $request);
        return view('app', ['data' => $data]);
    }

    private function add_meta_data($collection, $request)
    {
        $parts = explode('/', $request->getPathInfo());
        $index = end($parts);

        return $collection->merge([
            'path' => $request->getPathInfo(),
            'bike_index' => $index
        ]);
    }

}
