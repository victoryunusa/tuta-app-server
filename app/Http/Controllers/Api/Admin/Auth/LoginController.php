<?php

namespace App\Http\Controllers\Api\Admin\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use JWTFactory;
use JWTAuth;
use JWTAuthException;
use App\Driver;
use Illuminate\Support\Facades\Auth;
class LoginController extends Controller
{
        public function __construct()
    {
        $this->admin = new Driver;
    }
    
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255',
            'password'=> 'required'
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors());
        }
        config()->set( 'auth.defaults.guard', 'drivers' );
        \Config::set('jwt.user', 'App\Driver'); 
		\Config::set('auth.providers.users.model', \App\Driver::class);
		$credentials = $request->only('email', 'password');
		$token = null;
        try {
            if (! $token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'invalid_credentials'], 401);
            }
        } catch (JWTException $e) {
            return response()->json(['error' => 'could_not_create_token'], 500);
        }
                // user = JWTAuth::toUser($token);
//                 $user = Auth::user();
        $driver =  Auth::user();
        $driver->is_online = 1;
        $driver->save();
        
       // $driver->is_online = 1;
       // $driver->save();
      return response()->json(['token' => $token, 'data' => $driver], 200);
    }

    public function logout(Request $request) {
        $token = JWTAuth::getToken();
        $driver = Driver::where('id', $request->id)->firstOrFail();
        
        $driver->is_online = 0;
        $driver->save();
        //Auth::guard("driver")->logout();

        JWTAuth::invalidate($token);
        return response()->json(['info' => "Logged out", 'data' => $driver], 200);
    }
}
