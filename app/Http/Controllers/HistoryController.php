<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Cart;
use App\Models\CartDetail;
use App\Models\DetailOrder;

class HistoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $itemuser = $request->user();
        $itemcart = Cart::where('user_id', $itemuser->id)
                        ->first();
        
        $itemorder = Order::where('user_id', $itemuser->id)
                    ->orderBy('created_at', 'desc')
                    ->get();
        // $itemorder = Order::whereHas('cart', function($q) use ($itemuser) {
        //                     $q->where('user_id', $itemuser->id);
        //             })->orderBy('created_at', 'desc')
        //             ->get();             
        $cartdetail = CartDetail::where('cart_id', $itemcart->id)->first();
        // $itemcart = Cart::findOrFail($id);
        $data = array('title' => 'Form Edit Tracking',
                    'itemorder' => $itemorder,
                    'cartdetail' => $cartdetail,
                    'itemuser' => $itemuser,
                    'itemcart'=> $itemcart);
        return view('pages.history', $data)->with('no', 1);  
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
    public function show(Request $request, $id)
    {
        $itemuser = $request->user();
        $itemcart = Cart::where('user_id', $itemuser->id)
                        ->first();
        
        $itemorder = Order::findOrFail($id);
        $cartdetail = CartDetail::where('cart_id', $itemorder->cart->id)->first();
        // $itemcart = Cart::findOrFail($id);
        $data = array('title' => 'Form Edit Tracking',
                    'itemorder' => $itemorder,
                    'cartdetail' => $cartdetail,
                    'itemuser' => $itemuser,
                    'itemcart'=> $itemcart);
        
        // $itemuser = $request->user();
        // $itemcart = Cart::where('user_id', $itemuser->id)
        //                 ->first();
        // $itemorder = Order::findOrFail($id);
        // // $itemorder = Order::where('user_id', $itemuser->id)->first();
        // // $itemorder = Order::whereHas('cart', function($q) use ($itemuser) {
        // //                     $q->where('user_id', $itemuser->id);
        // //             })->orderBy('created_at', 'desc')
        // //             ->get();             
        // $cartdetail = CartDetail::where('cart_id', $itemcart->id)->first();
        // // $itemcart = Cart::findOrFail($id);
        // $data = array('title' => 'Form Edit Tracking',
        //             'itemorder' => $itemorder,
        //             'cartdetail' => $cartdetail,
        //             'itemuser' => $itemuser,
        //             'itemcart'=> $itemcart);
        return view('pages.detailHistory', $data)->with('no', 1);
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
