<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Auth;
use Validator;

class AuthController extends Controller
{
    public function login(Request $request)
    {

        $validation = Validator::make(
            $request->all(),
            [
                'email' => 'required|email',
                'password' => 'required|min:6',
            ]
        );

        $data = $validation->validated();
        $credentials = [
            'email' => $data['email'],
            'password' => $data['password'],
        ];

        if (Auth::attempt($credentials)) {
            $token = Auth::user()->createToken('auth_token')->plainTextToken; //'token_type' => 'Bearer',
            return $this->sendexternalResponse('success', $token, 201);
        }

        return $this->sendexternalResponse('invalid_cred', [], 400);
    }
    public function register(Request $request)
    {

        $validation = Validator::make(
            $request->all(),
            [
                'email' => 'required|email',
                'password' => 'required|min:6',
                'name' => 'required'
            ]
        );
        $data = $validation->validated();
        $user = User::create($data);
        Auth::login($user);
        $token = Auth::user()->createToken('auth_token')->plainTextToken; //'token_type' => 'Bearer',
        return $this->sendexternalResponse('success', $token, 201);
    }
}
