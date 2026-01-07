<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function login(Request $request){
        $inFields = $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        if(auth()->guard()->attempt(['email' => $inFields['email'], 'password' => $inFields['password']])){
            request()->session()->regenerate();

            $user = Auth::user();

            return match ($user->role) {
                'admin' => redirect()->route('admin.inventory.index'),
                'kasir' => redirect()->route('kasir.dashboard'),
                default => redirect('/'),
            };
        }
        return redirect('/');
    }

    public function logout(Request $request){
        auth()->guard()->logout();
        return redirect('/');
    }
}
