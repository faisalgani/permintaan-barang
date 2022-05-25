<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLokasiBarangsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lokasi_barang', function (Blueprint $table) {
            $table->increments('id', 10);
            $table->string('lokasi', 50);
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
        Schema::dropIfExists('lokasi_barang');
    }
}
