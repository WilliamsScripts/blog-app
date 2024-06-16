<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Api\LoginRequest;
use App\Http\Requests\Api\RegisterRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Hash;


class AuthController extends Controller
{
    /**
     * Register api
     *
     * @return \Illuminate\Http\Response
     */
    public function register(RegisterRequest $request): JsonResponse
    {
        $input = $request->all();
        $input['password'] = Hash::make($input['password']);
        $user = User::create($input);
        if ($user) {
            return $this->authenticate([
                "email" => $request->email,
                "password" => $request->password
            ]);
        }
    }

    /**
     * Login api
     *
     * @return \Illuminate\Http\Response
     */
    public function login(LoginRequest $request): JsonResponse
    {
        $input = $request->all();
        return $this->authenticate($input);
    }

    private function authenticate (array $request)
    {
        if(auth()->attempt(['email' => $request['email'], 'password' => $request['password']])){
            $user = auth()->user();
            $user = User::findOrFail($user->id);
            $token = $user->createToken('MyApp')->plainTextToken;
            $user->update(['token' => $token]);
            $data = UserResource::make($user);
            return $this->sendResponse('User logged in successfully.', $data);
        }
        else{
            return $this->sendError('Unauthorized', 401);
        }
    }
}
