<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransaksisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaksi', function (Blueprint $table) {
            $table->increments('id', 10);
            $table->string('no_transaksi', 10);
            $table->datetime('tgl_transaksi');
            $table->integer('id_customer');
            $table->foreign('id_customer')->references('id')->on('customer')->onDelete('cascade');
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
        Schema::dropIfExists('transaksi');
    }
}
