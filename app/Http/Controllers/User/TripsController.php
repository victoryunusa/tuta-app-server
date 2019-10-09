<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Trip;
use App\User;

class TripsController extends Controller
{
    public function index($id){
        
        $data['trips'] = User::with('trips')->where('id', $id)->get();


        return response()->json($data,  200);
    }
}
