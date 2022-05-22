<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    // use HasFactory;
    protected $table = 'kategoris';
    protected $fillable = [
        'kode_kategori',
        'nama_kategori',
        'foto',
        'jumlah',
        'user_id',
    ];

    public function user() {//user yang menginput data kategori
        return $this->belongsTo('App\Models\User', 'user_id');
    }

    public function kategori(){
        return $this->hasMany(Kategori::class, "kategori_id");
     }
}
