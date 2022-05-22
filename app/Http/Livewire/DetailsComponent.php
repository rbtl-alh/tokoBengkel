<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Produk;
use Cart;
use Illuminate\Support\Facades\DB;

class DetailsComponent extends Component
{
    // public $id;

    public function store($id, $nama, $harga){
        Cart::add($id, $nama, 1, $harga)->associate('App\Models\Produk');
        session()->flash('success_message', 'berhasil');
        return redirect()->route('produk.details');

    }

    // public function mount($id){
    //     $produk->id = $id;
    // }

    public function render(Produk $id)
    {
        // $itemproduk = Produk::where('id', $id)->first();
        $itemproduk = DB::table('produks')
        ->where('id', $id)
        ->first();
        // $popular_produk = Produk::inRandomOrder()->limit(4)->get();
        // $related_produk = Produk::where('kategori_id', $produk->kategori_id)->inRandomOrder()->limit(5)->get();
        return view('livewire.details-component', ['itemproduk'=>$itemproduk])->layout('layouts.customer');
    }
}
