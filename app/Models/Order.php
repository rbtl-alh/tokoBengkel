<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $table = 'orders';
    protected $fillable = [
        'user_id',
        'cart_id',
        'nama',
        'no_hp',
        'jenis_kendaraan',
        'plat_nomor',
        'ket',
        'keluhan',
        'kode_unik'
    ];
    
    public function user() {
        return $this->belongsTo('App\Models\User', 'user_id');
    }
    public function cart() {
        return $this->belongsTo('App\Models\Cart', 'cart_id');
    }
}
