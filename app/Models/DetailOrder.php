<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailOrder extends Model
{
    use HasFactory;
    protected $table = 'detail_orders';
    protected $fillable = [
        'user_id',
        'no_hp',
        'nama',
        'jenis_kendaraan',
        'plat_nomor',
        'ket',
        'keluhan',
        'kode_unik'
    ];
    
    public function user() {
        return $this->belongsTo('App\Models\User', 'user_id');
    }

    // public function updatekodeunik() {
    //     $this->attributes['kode_unik'] = rand(100, 999);
    //     self::save();
    // }
}
