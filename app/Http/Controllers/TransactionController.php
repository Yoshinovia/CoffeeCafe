<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index()
    {
        $menus = Menu::where('is_available', true)->get();
        return view('kasir.transaction.index', compact('menus'));
    }
}
