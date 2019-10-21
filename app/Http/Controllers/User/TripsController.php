<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use League\Geotools\Coordinate\Ellipsoid;
use League\Geotools\Coordinate\Coordinate as Coordinate;
use League\Geotools\Geotools as Geotools;

use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;

use Config;

use App\Trip;
use App\User;
use App\Driver;

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

        $waypoint0 = (float)$src_lat.','.(float)$src_long;
        $waypoint1 = (float)$dest_lat.','.(float)$dest_long;

        $result = $this->getDistance($waypoint0, $waypoint1);

        

        $body = json_decode($result->getBody()->getContents(), true);

        $route = $body['response']['route'][0]['summary'];
        $distance = $route['distance']/1000;
        $eta = ceil($route['trafficTime']/60);
        
        //Send the coordinates back
        $data['coordinates'] = ['src_lat' => $src_lat, 'src_long' => $src_long, 'dest_lat' => $dest_lat, 'dest_long' => $dest_long];

        //$data['driver'] = Driver::with('vehicle')->inRandomOrder()->first();

        //Calculate the price from distance(km)
        $data['price'] = $this->calculatePrice($distance, $eta);
        $data['eta'] = date('H:i', strtotime("+$eta minutes"));


        return response()->json($data,  200);

    }

    public function requestDriver(Request $request)
    {
        $src_lat = $request->src_lat;
        $src_long = $request->src_long;
        $dest_lat = $request->dest_lat;
        $dest_long = $request->dest_long;
        $user_id = $request->user_id;
        $fare = $request->fare;

        $data['trip'] = Trip::create([
            'src_lat' => $src_lat,
            'src_long' => $src_long,
            'dest_lat' => $dest_lat,
            'dest_long' => $dest_long,
            'user_id' => $user_id,
            'fare' => (float)$fare
        ]);

        //Initiallize geotools
        $geotools = new Geotools();
        $coordA   = new Coordinate([$src_lat, $src_long]);
        $coordB   = new Coordinate([$dest_lat, $dest_long]);
        $distance = $geotools->distance()->setFrom($coordA)->setTo($coordB);

        //Get distance in km
        $km = $distance->in('km')->haversine();


        $radius = 25;

        $data['driver'] = Driver::with('vehicle')->inRandomOrder()->first();
        # code...
        //$data['driver'] = CoreAPi::partner()->findInVicinity($lat, $long, $radius);

        return response()->json($data,  200);
    }

    public function calculatePrice($km, $eta){
        //Set base fare and price range
        $base_fare = 50;
        $tuta_small = 15;
        $tuta_mid = 25;
        $tuta_max = 35;
        $time = $eta/60;

        //Calculate price by price type and distance
        $price_small  = ceil(($tuta_small * $km)+($time*5) + $base_fare);
        $price_mid  = ceil(($tuta_mid * $km)+ ($time*7) + $base_fare);
        $price_max  = ceil(($tuta_max * $km)+ ($time*10) + $base_fare);

        return ['price_small' => $price_small,
                'price_mid' => $price_mid,
                'price_max' => $price_max
                ];
    }

    public function coordinate($coordinates, Ellipsoid $ellipsoid = null)
    {
        return new Coordinate($coordinates, $ellipsoid);
    }

    public function getDistance($waypoint0, $waypoint1){
        $app_id = config('hereapp.app_id');
        $app_code = config('hereapp.app_code');

        $uri = 'https://route.api.here.com/routing/7.2/calculateroute.json';

        $client = new Client(); //GuzzleHttp\Client
        $result = $client->request('GET', $uri, [
            'query' => [
                'waypoint0' => $waypoint0,
                'waypoint1' => $waypoint1,
                'mode' => 'fastest;car;traffic:enabled',
                'app_id' => $app_id,
                'app_code' => $app_code,
                'departure' => 'now'
            ]
        ]);

        return $result;
    }
    

}
