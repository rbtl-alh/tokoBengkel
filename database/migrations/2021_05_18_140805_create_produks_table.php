<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProduksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('produks', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('merk');
            $table->string('deskripsi');
            $table->integer('harga');
            $table->integer('stok');
            $table->string('foto');
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('kategori_id')->constrained('kategoris');
            // $table->foreign('user_id')->references('id')->on('users');
            // $table->foreign('kategori_id')->references('id')->on('kategori');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('produks');
    }
}
