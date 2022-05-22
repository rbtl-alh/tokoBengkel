<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;
    protected $table = 'carts';
    protected $fillable = [
        'user_id',
        'status_cart',
        'status_pembayaran',
        'status_pengiriman',
        'subtotal',
        'total',
    ];

    public function user() {
        return $this->belongsTo('App\Models\User','user_id');
    }

    public function detail() {
        return $this->hasMany('App\Models\CartDetail', 'cart_id');
    }

    public function updatetotal($itemcart, $subtotal) {
        $this->attributes['subtotal'] = $itemcart->subtotal + $subtotal;
        $this->attributes['total'] = $itemcart->total + $subtotal;
        self::save();
    }
}
