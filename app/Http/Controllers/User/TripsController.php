<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use League\Geotools\Coordinate\Ellipsoid;
use League\Geotools\Coordinate\Coordinate as Coordinate;
use League\Geotools\Geotools as Geotools;

use App\Trip;
use App\User;

class TripsController extends Controller
{
    public function index($id){
        
        $data['trips'] = User::with('trips')->where('id', $id)->get();


        return response()->json($data,  200);
    }

    public function book(Request $request){

        //Validate required inputs
        $this->validate($request, [
            'src_lat' => 'required',
            'src_long' => 'required',
            'dest_lat' => 'required',
            'dest_long' => 'required',
        ]);

        $src_lat = $request->input('src_lat');
        $src_long = $request->input('src_long');
        $dest_lat = $request->input('dest_lat');
        $dest_long = $request->input('dest_long');


        //Initiallize geotools
        $geotools = new Geotools();
        $coordA   = new Coordinate([$src_lat, $src_long]);
        $coordB   = new Coordinate([$dest_lat, $dest_long]);
        $distance = $geotools->distance()->setFrom($coordA)->setTo($coordB);

        //Get distance in km
        $km = $distance->in('km')->haversine();
        $data['km'] = $km;
        
        //Send the coordinates back
        $data['coordinates'] = ['src_lat' => $src_lat, 'src_long' => $src_long, 'dest_lat' => $dest_lat, 'dest_long' => $dest_long];

        //$data['driver'] = Driver::with('vehicle')->inRandomOrder()->first();

        //Calculate the price from distance(km)
        $data['price'] = $this->calculatePrice($km);


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

    public function calculatePrice($km){
        //Set base fare and price range
        $base_fare = 50;
        $tuta_small = 15;
        $tuta_mid = 20;
        $tuta_max = 35;

        //Calculate price by price type and distance
        $price_small  = ceil($tuta_small * $km + $base_fare);
        $price_mid  = ceil($tuta_mid * $km + $base_fare);
        $price_max  = ceil($tuta_max * $km + $base_fare);

        return ['price_small' => $price_small,
                'price_mid' => $price_mid,
                'price_max' => $price_max
                ];
    }

    public function coordinate($coordinates, Ellipsoid $ellipsoid = null)
    {
        return new Coordinate($coordinates, $ellipsoid);
    }
}
