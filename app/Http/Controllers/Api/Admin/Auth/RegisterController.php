<?php

namespace App\Http\Controllers\Api\Admin\Auth;
use Validator;
use JWTFactory;
use JWTAuth;
use JWTAuthException;
use App\Driver;
use Illuminate\Support\Facades\Hash;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RegisterController extends Controller
{
    public function register(Request $request)
    {
        $driver = Driver::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password)
        ]);

        // $token = $driver->createToken('tuta-app')->accessToken;
 
        // return response()->json(['token' => $token], 201);
        $token = JWTAuth::fromUser($driver);

        return response()->json(compact('driver','token'),201);

        
    }
}
