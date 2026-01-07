<?php

namespace App\Http\Controllers\Kasir;

use App\Http\Controllers\Controller;

class KasirController extends Controller
{
    public function dashboard()
    {
        return view('kasir.dashboard');
    }
}
