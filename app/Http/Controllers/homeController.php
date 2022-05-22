<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produk;
use App\Models\Kategori;

class homeController extends Controller
{
    public function index(Request $request) {
        $itemuser = $request->user();
            $itemproduk = Produk::orderBy('created_at', 'desc')->limit(3)->get();
            $itemkategori = Kategori::orderBy('nama_kategori', 'asc')->limit(6)->get();
            $data = array('title' => 'Homepage',
                'itemproduk' => $itemproduk,
                'itemuser' => $itemuser,
                'itemkategori' => $itemkategori,
            );
            return view('pages.home', $data);
    }

    public function login() {
        // $data = array('title' => 'Homepage');
        // return view('pages.home2', $data);
        $itemproduk = Produk::orderBy('created_at', 'desc')->limit(6)->get();
            $itemkategori = Kategori::orderBy('nama_kategori', 'asc')->limit(6)->get();
            $data = array('title' => 'Homepage',
                'itemproduk' => $itemproduk,
                'itemkategori' => $itemkategori,
            );
            return view('pages.home2', $data);
    }

    public function kategori() {
        $itemkategori = Kategori::orderBy('nama_kategori', 'asc')->limit(6)->get();
        $itemproduk = Produk::orderBy('created_at', 'desc')->limit(6)->get();
        $data = array('title' => 'Kategori Produk',
                    'itemkategori' => $itemkategori,
                    'itemproduk' => $itemproduk);
        return view('pages.listKategori', $data);
    }

    // public function kategori() {
    //     $itemkategori = Kategori::orderBy('nama_kategori', 'asc')->limit(6)->get();
    //     $itemproduk = Produk::orderBy('created_at', 'desc')->limit(6)->get();
    //     $data = array('title' => 'Kategori Produk',
    //                 'itemkategori' => $itemkategori,
    //                 'itemproduk' => $itemproduk);
    //     return view('pages.home', $data);
    // }

    public function kategoribyid(Request $request, $id) {
        // $itemproduk = Produk::orderBy('nama', 'desc')
        //                     ->whereHas('kategori', function($q) use ($id) {
        //                         $q->where('id', $id);
        //                     })
        //                     ->paginate(18);
        // $listkategori = Kategori::orderBy('nama_kategori', 'asc')                                
        //                         ->get();
        // $itemkategori = Kategori::findOrFail($id);
        // if ($itemkategori) {
        //     $data = array('title' => $itemkategori->nama_kategori,
        //                 'itemproduk' => $itemproduk,
        //                 'listkategori' => $listkategori,
        //                 'itemkategori' => $itemkategori);
        //     return view('pages.home', $data)->with('no', ($request->input('page') - 1) * 18);            
        // } else {
        //     return abort('404');
        // }
        $itemuser = $request->user();
        $itemkategori = Kategori::findOrFail($id);//cari berdasarkan id = $id, 
        $itemproduk = Produk::orderBy('nama', 'desc')
                            ->whereHas('kategori', function($q) use ($id) {
                                $q->where('id', $id);
                            })
                            ->paginate(18);
        $listkategori = Kategori::orderBy('nama_kategori', 'asc')                                
                            ->get();
        // kalo ga ada error page not found 404
        $data = array('title' => 'Produk Kategori',
                    'itemkategori' => $itemkategori,
                    'itemproduk' => $itemproduk,
                    'itemuser' => $itemuser,
                    'listkategori' => $listkategori);
        return view('pages.listKategori', $data);

        
    }

    public function produk(Request $request) {
        $itemproduk = Produk::orderBy('nama', 'desc')
                            ->paginate(18);
        $listkategori = Kategori::orderBy('nama_kategori', 'asc')
                                ->get();
        $data = array('title' => 'Produk',
                    'itemproduk' => $itemproduk,
                    'listkategori' => $listkategori);
        return view('pages.listKategori', $data)->with('no', ($request->input('page') - 1) * 18);
    }

    // public function produkdetail($id) {
    //     $itemproduk = Produk::where('id', $id)
    //                         ->first();
    //     if ($itemproduk) {
    //         $data = array('title' => $itemproduk->nama,
    //                     'itemproduk' => $itemproduk);
    //         return view('pages.detailProduk', $data);            
    //     } else {
    //         // kalo produk ga ada, jadinya tampil halaman tidak ditemukan (error 404)
    //         return abort('404');
    //     }
    // }

    public function produkdetail(Request $request, $id) {
        $itemuser = $request->user();
        $itemproduk = Produk::where('id', $id)
                            ->first();
        if ($itemproduk) {
            $data = array('title' => $itemproduk->nama_produk,
                        'itemproduk' => $itemproduk,
                        'itemuser' => $itemuser);
            return view('pages.detailProduk', $data);            
        } else {
            // kalo produk ga ada, jadinya tampil halaman tidak ditemukan (error 404)
            return abort('404');
        }
    }

    public function about(Request $request)
    {
        //about us
        $itemuser = $request->user();
        return view('pages.about', compact('itemuser'));
    }

}
