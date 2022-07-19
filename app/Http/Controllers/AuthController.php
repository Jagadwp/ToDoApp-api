<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\ApiResponse;

class AuthController extends Controller
{
    use ApiResponse;
    public function login(Request $request){
        
        $data = $request->validate([
            'email' => 'email|required',
            'password' => 'required'
        ]);
        
        if (!auth()->attempt($data)) {
            return $this->sendBadCred();
        }

        $token = auth()->user()->createToken('API_TOKEN')->accessToken;

        $data = [
            'user' => auth()->user(), 
            'token' => $token
        ];

        return $this->sendData($data);
    }
}
 