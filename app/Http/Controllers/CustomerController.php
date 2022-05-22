<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $itemuser = $request->user();
        $user = $request->user()->get();
        $data = array('title' => 'Data Customer',
                    'itemuser' => $itemuser,
                    'user' => $user);
        // if($itemuser->role == 'admin'){
            return view('customer.index', $data)->with('no', 1);
        // }
        // else{
        //     return view('pages.bukanadmin');
        // }
    }

    public function search(Request $request)
    {
        // $search_text = $_GET['kode_unik'];x
        // $itemorder = DB::table('orders')
        //             ->where('kode_unik','LIKE','%'.$search_text.'%')
        //             ->paginate();
        // $itemorder = Order::where('cart_id', $itemcart->id)->get();
        //$products = Sparepart::where('nama','LIKE','%'.$search_text.'%')->with('nama')->get();
        $request->validate([
            'search'=>'required|min:2'
         ]);

         $search_text = $request->input('search')->get();
         $itemuser = User::where('username','LIKE','%'.$search_text.'%')
                    // ->where('cart_id', $itemcart->id)
                  //   ->orWhere('SurfaceArea','<', 10)
                  //   ->orWhere('LocalName','like','%'.$search_text.'%')
                    ->paginate(2);
        return view('customer.index', compact('itemuser'));
    }

    public function showName(Request $request)
    {
        $itemuser = $request->user();
        $data = array('itemuser' => $itemuser);
        return view('layouts.dashboard', $data);
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
        $itemuser = User::findOrFail($id);
        $data = array('title' => 'Form Edit Customer',
                        'itemuser' => $itemuser);
        return view('customer.edit', $data);
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
        $itemuser = User::findOrFail($id);

        $inputan = $request->all();
        $inputan['id'] = $id;
        $itemuser->update($inputan);
        return redirect()->route('customer.index')->with('success', 'Data customer berhasil diupdate');
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
