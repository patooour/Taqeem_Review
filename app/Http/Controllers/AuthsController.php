<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Api\ApiResponseTrait;
use App\Http\Resources\PostResourse;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class AuthsController extends Controller
{
    use ApiResponseTrait;

    public function __construct() {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }
    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request){
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        if (! $token = auth()->attempt($validator->validated())) {
          //  return response()->json(['error' => 'Unauthorized'], 401);
            return response()->json(['error' => 'Unauthorized'], 203);

        }
        $user=auth()->user();
        $u=User::select()->get();
        return $this->createNewToken($token);

    }
    public function register(Request $request) {
        $validator = Validator::make($request->all(), [
            'firstname'=>'required|string',
            'lastname'=>'required|string',
            'username' => 'required|string|between:2,100',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string',
            'country'=>'required|string',
            'gender'=>'required|string',

        ]);
        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }

        $users = User::create(array_merge(
            $validator->validated(),

            [
                'password' => bcrypt($request->password),

                ]
        ));

        return response()->json($users);

    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout() {
        $user=auth()->user();
        $user->update(['api_token'=>null]);
        auth()->logout();
        return response()->json(['message' => 'User successfully signed out']);

    }
    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh() {
        $user=auth()->user();
       // $tok=$this->gettoken(auth()->refresh());
      //  $user->update(['api_token'=>$tok]);
        return $this->createNewToken(auth()->refresh());
    }
    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function userProfile() {
        return response()->json(auth()->user());
    }
    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */

    protected function createNewToken($token){
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60,
            'user' => auth()->user()
        ]);
    }
    protected function gettoken($token){
        return $token;
    }

}
