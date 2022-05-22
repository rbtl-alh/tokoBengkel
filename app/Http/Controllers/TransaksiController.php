<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Order;
use App\Models\DetailOrder;
use App\Models\CartDetail;
use App\Models\Produk;


class TransaksiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $itemuser = $request->user();
            // kalo admin maka menampilkan semua cart
            $itemorder = Order::whereHas('cart', function($q) use ($itemuser) {
                            // $q->where('status_cart', 'checkout');
                        })
                        ->orderBy('created_at', 'desc')
                        ->paginate(20);
        // else {
        //     // kalo member maka menampilkan cart punyanya sendiri
        //     $itemorder = Order::whereHas('cart', function($q) use ($itemuser) {
        //                     $q->where('status_cart', 'checkout');
        //                     $q->where('user_id', $itemuser->id);
        //                 })
        //                 ->orderBy('created_at', 'desc')
        //                 ->paginate(20);
        // }
        $data = array('title' => 'Data Tracking',
                    'itemorder' => $itemorder,
                    'itemuser' => $itemuser);

        if($itemuser->role == 'admin'){
            return view('transaksi.index', $data)->with('no', 1);
        }else{
            return view('pages.bukanadmin');
        }
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
        $itemuser = $request->user();
        $itemcart = Cart::where('status_cart', 'cart')
                        ->where('user_id', $itemuser->id)
                        ->first();
        // $config = [
        //     'table' => 'orders',
        //     'length' => 6,
        //     'prefix' => date('y')
        // ];
        
        // now use it
        // $kode_unik = IdGenerator::generate($config);
        
        // $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';

        // // generate a pin based on 2 * 7 digits + a random character
        // $pin = mt_rand(1000000, 9999999)
        //     . mt_rand(1000000, 9999999)
        //     . $characters[rand(0, strlen($characters) - 1)];

        // // shuffle the result
        // $kode_unik = str_shuffle($pin);
        // // $kode_unik = str_random(15);
        // $min=100;
        // $min=100;
        if ($itemcart) {
            $itemorder = DetailOrder::where('user_id', $itemuser->id)
                                                    ->first();
            if ($itemorder) {
                // buat variabel inputan order
                $inputanorder['cart_id'] = $itemcart->id;
                $inputanorder['nama'] = $itemorder->nama;
                $inputanorder['no_hp'] = $itemorder->no_hp;
                $inputanorder['jenis_kendaraan'] = $itemorder->jenis_kendaraan;
                $inputanorder['plat_nomor'] = $itemorder->plat_nomor;
                $inputanorder['ket'] = $itemorder->ket;
                $inputanorder['keluhan'] = $itemorder->keluhan;
                // $inputanorder['kode_unik']->update(['kode_unik' => rand()]);
                // $inputanorder['kode_unik'] = IdGenerator::generate($config);
                $itemorder = Order::create([$inputanorder, 
                                            'kode_unik' => rand(0,50),]);//simpan order
                // update status cart
                $itemcart->update(['status_cart' => 'checkout']);
                return redirect()->route('transaksi.index')->with('success', 'Tracking berhasil disimpan');
                // return view('checkout')->with('success', 'Order berhasil disimpan');
            } else {
                return back()->with('error', 'Data pengiriman belum diisi');
            }
        } else {
            return abort('404');//kalo ternyata ga ada shopping cart, maka akan menampilkan error halaman tidak ditemukan
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = array('title' => 'Detail Tracking');
        return view('transaksi.index', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        $itemuser = $request->user();
        $itemcart = Cart::where('user_id', $itemuser->id)
                        ->first();
        
        if ($itemuser->role == 'admin') {
            $itemorder = Order::findOrFail($id);
            $cartdetail = CartDetail::where('cart_id', $itemorder->cart->id)->first();
            // $itemcart = Cart::findOrFail($id);
            $data = array('title' => 'Form Edit Tracking',
                        'itemorder' => $itemorder,
                        'cartdetail' => $cartdetail,
                        'itemuser' => $itemuser,
                        'itemcart'=> $itemcart);
            return view('transaksi.edit', $data)->with('no', 1);            
        } else {
            return abort('404');//kalo bukan admin maka akan tampil error halaman tidak ditemukan
        }
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
        $this->validate($request,[
            'status_pembayaran' => 'required',
            'status_cart' => 'required',
        ]);
        $inputan = $request->all();
        $inputan['status_pembayaran'] = $request->status_pembayaran;
        $inputan['status_cart'] = $request->status_cart;
        $itemorder = Order::findOrFail($id);
        $itemorder->cart->update($inputan);
        return redirect()->route('transaksi.index')->with('success','Order berhasil diupdate');
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
