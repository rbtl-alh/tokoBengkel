<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Models\DetailOrder;
use App\Models\Cart;
use App\Models\Order;
use Illuminate\Http\Request;

class DetailOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $itemuser = $request->user();
        $itemorder = DetailOrder::where('user_id', $itemuser->id)->paginate(10);
        $data = array('title' => 'Order',
                    'itemuser' => $itemuser,
                    'itemorder' => $itemorder);
        return view('pages.order', $data)->with('no', ($request->input('page', 1) - 1) * 10);
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
        $this->validate($request, [
            'nama' => 'required',
            'no_hp' => 'required',
            'jenis_kendaraan' => 'required',
            'plat_nomor' => 'required',
            'ket' => 'required',
            'keluhan' => 'required',
        ]);
        $itemuser = $request->user();//ambil data user yang sedang login
        $inputan = $request->all();//buat variabel dengan nama $inputan
        // $inputan['user_id'] = $itemuser->id;
        // $inputan['kode_unik']->update(rand(0,50));
        // $inputan['status'] = 'utama';
        // $itemorder = DetailOrder::create($inputan);
        // set semua status alamat pengiriman bukan utama
        // DetailOrder::where('id', '!=', $itemorder->id);
                    // ->update(['status' => 'tidak']);
        // return back()->with('success', 'Data Order berhasil disimpan');

        // $itemuser = $request->user();
        $itemcart = Cart::where('status_cart', 'cart')
                        ->where('user_id', $itemuser->id)
                        ->first();
        if ($itemcart) {
            // $itemorder = $request->user();//ambil data user yang sedang login
            // $itemorder = $request->all();
            // $itemorder = Order::findOrFail($id);
            // $itemorder = Order::where('cart_id', $itemcart->id);
            $itemorder = DetailOrder::where('user_id', $itemuser->id);
            if ($itemorder) {
                // buat variabel inputan order
                $inputanorder['cart_id'] = $itemcart->id;
                $inputanorder['user_id'] = $itemuser->id;
                $inputanorder['nama'] = $request->nama;
                $inputanorder['no_hp'] = $request->no_hp;
                $inputanorder['jenis_kendaraan'] = $request->jenis_kendaraan;
                $inputanorder['plat_nomor'] = $request->plat_nomor;
                $inputanorder['ket'] = $request->ket;
                $inputanorder['keluhan'] = $request->keluhan;
                $inputanorder['kode_unik']  = Helper::IDGenerator(new Order, 'kode_unik', 4, 'TB');
                // $inputanorder['kode_unik'] = $itemorder->update(['kode_unik' => rand(100, 999)]); 
                // session()->put('kode_unik',  rand(100, 999));
                // $itemorder = Order::create($kode_unik);//simpan order
                $itemorder = Order::create($inputanorder);//simpan order
                $itemdetail = DetailOrder::create($inputanorder);//simpan order
                // $itemdetail = DetailOrder::create($inputanorder);//simpan order
                // update status cart
                $itemcart->update(['status_cart' => 'checkout']);
                $data = array('title' => 'Alamat Pengiriman',
                        'itemorder' => $itemorder,
                        'itemdetail' => $itemdetail,
                        'itemcard'=>$itemuser);
                return redirect()->route('history.index')->with('alert', 'Order berhasil disimpan');
                // return view('pages.checkout', $data)->with('success', 'Order berhasil disimpan');
            } 
        } else {
            return abort('404');//kalo ternyata ga ada shopping cart, maka akan menampilkan error halaman tidak ditemukan
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\DetailOrder  $detailOrder
     * @return \Illuminate\Http\Response
     */
    public function show(DetailOrder $detailOrder)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\DetailOrder  $detailOrder
     * @return \Illuminate\Http\Response
     */
    public function edit(DetailOrder $detailOrder)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\DetailOrder  $detailOrder
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, DetailOrder $detailOrder)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\DetailOrder  $detailOrder
     * @return \Illuminate\Http\Response
     */
    public function destroy(DetailOrder $detailOrder)
    {
        //
    }
}
