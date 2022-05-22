<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    use HasFactory;
    protected $table = 'produks';
    protected $fillable=[
        'nama', 
        'merk',
        'deskripsi',
        'harga',
        'stok',
        'foto',
        'user_id',
        'kategori_id',
    ];

    public function user() {
        return $this->belongsTo('App\Models\User', 'user_id');
    }

    public function kategori() {
        return $this->belongsTo(Kategori::class);
    }

    public function images() {
        return $this->hasMany('App\Models\ProdukImage', 'produk_id');
    }

}
