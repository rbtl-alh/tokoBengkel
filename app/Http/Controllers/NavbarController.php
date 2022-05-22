<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class NavbarController extends Controller
{
    public function index(Request $request){
        $itemuser = $request->user();
        $data = array('itemuser' => $itemuser);
        return view('components.navbar2', $data);
    }
}
