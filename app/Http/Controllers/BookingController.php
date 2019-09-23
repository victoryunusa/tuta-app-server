<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use League\Geotools\Coordinate\Ellipsoid;
use League\Geotools\Coordinate\Coordinate as Coordinate;
use League\Geotools\Geotools as Geotools;

use App\Driver;
use App\Http\Resources\DriverResource;

class BookingController extends Controller
{
    public function book(Request $request){
        $this->validate($request, [
            'where_from' => 'required',
            'where_to' => 'required',
        ]);

        $geotools = new Geotools();
        $coordA   = new Coordinate([9.05785, 7.49508]);
        $coordB   = new Coordinate([9.0776387, 7.4737235]);
        $distance = $geotools->distance()->setFrom($coordA)->setTo($coordB);

        $base_fare = 50;

        $tuta_small = 15;

       $km = $distance->in('km')->haversine();
       $data['km'] = $km;

        $data['where_from'] = trim($request->where_from);
        $data['where_to'] = trim($request->where_to);
        $data['driver'] = Driver::with('vehicle')->inRandomOrder()->first();
        $data['price'] = $tuta_small * $km + $base_fare;


        return response()->json($data,  200);

    }

    public function requestDriver(Request $request)
    {
        $lat = $request->lat;
        $long = $request->long;
        $radius = 25;
        # code...
        CoreAPi::partner()->findInVicinity($lat, $long, $radius);
    }

    public function calculatePrice(){

    }

    public function coordinate($coordinates, Ellipsoid $ellipsoid = null)
    {
        return new Coordinate($coordinates, $ellipsoid);
    }
}
