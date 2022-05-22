<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Cart;
use App\Models\CartDetail;
use Illuminate\Support\Facades\DB;

class TrackingCustController extends Controller
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
        return view('pages.tracking', $data)->with('no', 1);            
    }

    public function search(Request $request)
    {
        // $search_text = $_GET['kode_unik'];
        $itemuser = $request->user();
        $itemcart = Cart::where('user_id', $itemuser->id)
                        ->first();
                        $search_text = $request->search;
        // $itemorder = DB::table('orders')
        //             ->where('kode_unik','LIKE','%'.$search_text.'%')
        //             ->paginate();
        // $itemorder = Order::where('cart_id', $itemcart->id)->get();
        //$products = Sparepart::where('nama','LIKE','%'.$search_text.'%')->with('nama')->get();
        $request->validate([
            'search'=>'required|min:2'
         ]);

         $search_text = $request->input('search');
         $itemorder = Order::whereHas('cart', function($q) use ($itemuser) {
            //$q->where('status_cart', 'checkout');
        });
         $itemorder = Order::where('kode_unik','LIKE','%'.$search_text.'%')
                    // ->where('cart_id', $itemcart->id)
                  //   ->orWhere('SurfaceArea','<', 10)
                  //   ->orWhere('LocalName','like','%'.$search_text.'%')
                    ->paginate(2);
            $data = array('itemorder'=> $itemorder, 'itemuser' => $itemuser);
        return view('pages.tracking-2', $data);
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
