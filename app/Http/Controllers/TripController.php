<?php

namespace App\Http\Controllers;

use App\Http\Requests\TripRequest;
use App\Trip;

class TripController extends Controller
{
    public function index()
    {
        $trips = Trip::latest()->get();

        return response(['data' => $trips ], 200);
    }

    public function store(TripRequest $request)
    {
        $trip = Trip::create($request->all());

        return response(['data' => $trip ], 201);

    }

    public function show($id)
    {
        $trip = Trip::findOrFail($id);

        return response(['data', $trip ], 200);
    }

    public function update(TripRequest $request, $id)
    {
        $trip = Trip::findOrFail($id);
        $trip->update($request->all());

        return response(['data' => $trip ], 200);
    }

    public function destroy($id)
    {
        Trip::destroy($id);

        return response(['data' => null ], 204);
    }
}
