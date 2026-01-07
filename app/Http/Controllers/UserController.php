<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function login(Request $request){
        $inFields = $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        if(auth()->guard()->attempt(['email' => $inFields['email'], 'password' => $inFields['password']])){
            request()->session()->regenerate();

            if (auth()->guard()->user()->role === 'admin') {
                return redirect('/ahome');
            }
        }
        return redirect('/');
    }

    public function logout(Request $request){
        auth()->guard()->logout();
        return redirect('/');
    }
}
