<?php

namespace App\Http\Controllers\Driver;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Driver;
use App\Vehicle;
use App\VehicleCategory;

class VehicleController extends Controller
{
    public function addVehicle(Request $request){

        try{
            $vehicle = Vehicle::create($request->all());

            return response(['data' => $vehicle ], 201);
        } catch (Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }
        
    }
}
