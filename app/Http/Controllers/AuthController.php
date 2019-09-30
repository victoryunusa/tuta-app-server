<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\DriverRequest;

use App\User;
use App\Driver;

use Illuminate\Support\Facades\Auth;

use Validator;
use Illuminate\Support\Facades\Hash;


class AuthController extends Controller
{
    /**
     * Handles Registration Request
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request)
    {
        //Validate User inputs
        $this->validate($request, [
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
        ]);
        
        //Create new user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);
        
        //Create access token
        $token = $user->createToken('tuta-app')->accessToken;
        
        //Send Access Token
        return response()->json(['token' => $token], 200);
    }

    public function registerDriver(DriverRequest $request)
    {
        //Validate Driver inputs

        //Create New Driver
        $driver = Driver::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password)
        ]);

        $token = $driver->createToken('tuta-app')->accessToken;
 
        return response()->json(['token' => $token], 201);
    }
 
    /**
     * Handles Login Request
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $credentials = [
            'email' => $request->email,
            'password' => $request->password
        ];
 
        if (auth()->attempt($credentials)) {
            $token = auth()->user()->createToken('tuta-app')->accessToken;
            return response()->json(['token' => $token], 200);
        } else {
            return response()->json(['error' => 'UnAuthorised'], 401);
        }
    }

    public function loginDriver(Request $request)
    {
        $credentials = [
            'email' => $request->email,
            'password' => $request->password
        ];
 
        if (auth()->guard('driver')->attempt($credentials)) {
            $token = auth()->guard('driver')->user()->createToken('tuta-app')->accessToken;
            return response()->json(['token' => $token], 200);
        } else {
            return response()->json(['error' => 'UnAuthorised'], 401);
        }
    }
    
}
