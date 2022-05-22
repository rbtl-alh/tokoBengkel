<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produk;

class ProductCustController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $itemuser = $request->user();
        $itemproduk = Produk::orderBy('created_at', 'desc')->get();
            $data = array('title' => 'Homepage',
                'itemproduk' => $itemproduk,
                'itemuser' => $itemuser,
            );
            return view('pages.product', $data);
    }

    public function search(Request $request)
    {
        $request->validate([
            'search'=>'required|min:2'
         ]);

         $itemuser = $request->user();
         $search_text = $request->input('search');
         $itemproduk = Produk::where('nama','LIKE','%'.$search_text.'%')
                    // ->where('cart_id', $itemcart->id)
                  //   ->orWhere('SurfaceArea','<', 10)
                  //   ->orWhere('LocalName','like','%'.$search_text.'%')
                    ->paginate(2);
        $data = array('itemproduk' => $itemproduk,
                    'itemuser' => $itemuser);
        return view('pages.product', $data);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        // $itemproduk = Produk::findOrFail($id);//cari berdasarkan id = $id, 
        // // kalo ga ada error page not found 404
        // $data = array('title' => 'Form Edit Kategori',
        //             'itemproduk' => $itemproduk);
        // return view('pages.detailproduk', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
