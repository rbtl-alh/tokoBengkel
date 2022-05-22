<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\DetailOrder;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $itemuser = $request->user();//ambil data user
        $itemcart = Cart::where('user_id', $itemuser->id)
                        ->where('status_cart', 'cart')
                        ->first();
        // $data = array('title' => 'Shopping Cart',
        //             'itemcart' => $itemcart);
        // return view('pages.trolley', $data);
        if ($itemcart) {
            $data = array('title' => 'Shopping Cart',
                        'itemcart' => $itemcart,
                        'itemuser' => $itemuser);
            return view('pages.trolley', $data)->with('no', 1);            
        } else {
            return view('pages.trolley_kosong', compact('itemuser'));
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function show(Cart $cart)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function edit(Cart $cart)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Cart $cart)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function destroy(Cart $cart)
    {
        //
    }

    public function kosongkan($id) {
        $itemcart = Cart::findOrFail($id);
        $itemcart->detail()->delete();//hapus semua item di cart detail
        $itemcart->updatetotal($itemcart, '-'.$itemcart->subtotal);
        return back()->with('success', 'Cart berhasil dikosongkan');
    }

    public function checkout(Request $request) {
        $itemuser = $request->user();
        $itemcart = Cart::where('user_id', $itemuser->id)
                        ->where('status_cart', 'cart')
                        ->orderBy('created_at', 'desc')
                        ->first();
        $itemdetail= DetailOrder::where('user_id', $itemuser->id)->get();
        // $itemorder= Order::where('cart_id', $itemcart->id)->get();
                                                // ->where('status', 'utama')
                                                
        $data = array('title' => 'Checkout',
                    'itemcart' => $itemcart,                    
                'itemdetail' => $itemdetail);
        return view('pages.checkout', $data)->with('no', 1);
    }
}
