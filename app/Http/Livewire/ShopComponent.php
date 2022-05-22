<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Produk;
use Cart;
// use App\Models\Cart;
// use App\Models\CartDetail;


class ShopComponent extends Component
{
    public function store($id, $nama, $harga){
        Cart::add($id, $nama, 1, $harga)->associate('App\Models\Produk');
        session()->flash('success_message', 'berhasil');
        return redirect()->route('produk.cart');

    }


    use WithPagination;
    public function render()
    {
        $produk = Produk::paginate(6);
        return view('livewire.shop-component', ['produk'=>$produk])->layout('layouts.customer');
    }

    // public function store($id, $nama, $harga){
    //     Cart::add($id, $nama, $harga)->associate('App\Models\Produk');
    //     session()->flash('success_message', 'produk berhasil ditambahkan');
    //     return redirect()->route('');

    // }
}
