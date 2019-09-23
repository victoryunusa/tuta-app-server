<?php

namespace App\Http\Controllers;

use App\Http\Requests\VehicleCategoryRequest;
use App\VehicleCategory;

class VehicleCategoryController extends Controller
{
    public function index()
    {
        $vehiclecategories = VehicleCategory::latest()->get();

        return response(['data' => $vehiclecategories ], 200);
    }

    public function store(VehicleCategoryRequest $request)
    {
        $vehiclecategory = VehicleCategory::create($request->all());

        return response(['data' => $vehiclecategory ], 201);

    }

    public function show($id)
    {
        $vehiclecategory = VehicleCategory::findOrFail($id);

        return response(['data', $vehiclecategory ], 200);
    }

    public function update(VehicleCategoryRequest $request, $id)
    {
        $vehiclecategory = VehicleCategory::findOrFail($id);
        $vehiclecategory->update($request->all());

        return response(['data' => $vehiclecategory ], 200);
    }

    public function destroy($id)
    {
        VehicleCategory::destroy($id);

        return response(['data' => null ], 204);
    }
}
