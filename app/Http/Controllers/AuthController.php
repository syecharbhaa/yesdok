<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\User;

class AuthController extends Controller
{
    public function login(Request $r){
        $res['status'] = 'error';
        $res['message'] = 'Wrong credentials!';
        $code = 500;

        $email = $r->input('email');
        $pwd = $r->input('password');

        $check = User::where('email', $email)->first();;

        if($check){
            if(Hash::check($pwd, $check->password)){
                $token = base64_encode(Str::random(40));
    
                $check->update(['api_token' => $token]);
    
                unset($res['message']);
                $res['status'] = 'success';
                $res['data'] = ['user' => $check, 'api_token' => $token, 'role' => $check->role->name];
                $code = 200;
            }
        }

        if(!isset($email)){
            unset($res['message']);
            $res['status'] = 'fail';
            $res['data'] = ['email' => 'Email is required'];
            $code = 403;
        }

        if(!isset($pwd)){
            unset($res['message']);
            $res['status'] = 'fail';
            $res['data'] = ['password' => 'Password is required'];
            $code = 403;
        }

        return response($res, $code);
    }
}
