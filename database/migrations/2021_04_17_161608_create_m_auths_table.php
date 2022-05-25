<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMAuthsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /**
         * 
         * id varchar PK 
         * username varchar(30)
         * password varchar(225)
         * active boolean
         * last_login datetime
         * created_at datetime
         * updated_at datetime
         */
        if(!Schema::hasTable('auth')){
            Schema::create('auth', function (Blueprint $table) {
                $table->string('id');
                $table->primary('id');
                $table->foreign('id')->references('id')->on('users')
                ->onUpdate('cascade')
                ->onDelete('cascade');
                $table->string('username', 30);
                $table->string('password')->nullable();
                $table->boolean('active')->default(false);
                $table->datetime('last_login')->nullable()->default(null);
                $table->datetime('created_at')
                ->default(date("Y-m-d H:i:s"));
                $table->datetime('updated_at')
                ->default(date("Y-m-d H:i:s"));
                $table->datetime('deleted_at')->nullable();
                $table->engine = 'InnoDB';
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('auth');
    }
}
