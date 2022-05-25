<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMUsersTable extends Migration
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
         * first_name varchar(30)
         * last_name varchar(100)
         * address text
         * phone varchar(15)
         * email varchar(100)
         * birthdate date
         * gender boolean
         * photo varchar(100)
         * created_at datetime
         * updated_at datetime
         */
        if(!Schema::hasTable('users')){
            Schema::create('users', function (Blueprint $table) {
                $table->string('id');
                $table->primary('id');
                $table->string('first_name', 30);
                $table->string('last_name', 100)->nullable();
                $table->text('address')->nullable();
                $table->string('phone', 15)->nullable();
                $table->string('email', 30);
                $table->date('birthdate')->default(date("Y-m-d"));
                $table->boolean('gender')->default(true);
                $table->string('photo')->nullable();
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
        Schema::dropIfExists('users');
    }
}
