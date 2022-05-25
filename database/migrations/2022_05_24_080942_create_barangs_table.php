<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBarangsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('barang', function (Blueprint $table) {
            $table->increments('id', 10);
            $table->string('nama_barang', 50);
            $table->integer('stok');
            $table->integer('id_lokasi');
            $table->integer('id_satuan');
            $table->foreign('id_lokasi')->references('id')->on('lokasi_barang')->onDelete('cascade');
            $table->foreign('id_satuan')->references('id')->on('satuan_barang')->onDelete('cascade');
            $table->datetime('created_at')->default(date("Y-m-d H:i:s"));
            $table->datetime('updated_at')->default(date("Y-m-d H:i:s"));
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('barang');
    }
}
