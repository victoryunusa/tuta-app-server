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
            return response(['error' => $e->getMessage() ], 500);
        }
        
    }

    public function updateVehicle(Request $request, $id){
        try{
            $vehicle = Vehicle::findOrFail($id);
            $vehicle->update($request->all());
            //Return response
            return response(['message' => 'Updated sucessfully' ,'data' => $vehicle ], 200);
        } catch(Exception $e) {
            return response(['error' => $e->getMessage() ], 500);
        }
    }
}
