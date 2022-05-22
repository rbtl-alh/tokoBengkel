<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produk;
use App\Models\Kategori;
use App\Models\User;

class DashboardController extends Controller
{
    public function index(Request $request) 
    {
        $itemuser = $request->user();
        $itemproduk = Produk::orderBy('created_at', 'desc')->paginate(5);
        $itemkategori = Kategori::where('nama_kategori', $request->nama_kategori)->get();
        $data = array('title' => 'Produk',
                    'itemproduk' => $itemproduk,
                    'itemuser' => $itemuser,
                    'itemkategori' => $itemkategori);
        if($itemuser->role == 'admin'){
            return view('dashboard.index', $data)->with('no', ($request->input('page', 1) - 1) * 20);
        }else{
            return view('pages.bukanadmin');
        }
    }

    // public function showName(Request $request)
    // {
    //     $itemuser = $request->user();
    //     $data = array('itemuser' => $itemuser);
    //     return view('layouts.dashboard', $data);
    // }

    // public function menu(){
    //     $user = User::all();
    //     return view('layouts.dashboard', compact('user'));
    // }
}
