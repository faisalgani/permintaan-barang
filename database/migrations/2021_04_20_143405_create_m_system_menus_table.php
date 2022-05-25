<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMSystemMenusTable extends Migration
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
         * menu varchar(30)
         * link text
         * icon varchar(15)
         * parent int(3)
         * class varchar(50)
         * active bit
         * state varchar(25)
         * order varchar(10)
         * created_at datetime
         * updated_at datetime
         */
        if(!Schema::hasTable('system_menu')){
            Schema::create('system_menu', function (Blueprint $table) {
                $table->string('id');
                $table->primary('id');
                $table->string('menu', 30);
                $table->text('link');
                $table->string('icon', 15)->nullable();
                $table->string('parent')->nullable();
                $table->string('class', 50)->nullable();
                $table->string('state', 25)->nullable();
                $table->string('order', 10)->nullable();
                $table->boolean('active')->default(true);
                $table->datetime('created_at')
                ->default(date("Y-m-d H:i:s"));
                $table->datetime('updated_at')
                ->default(date("Y-m-d H:i:s"));
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
        Schema::dropIfExists('system_menu');
    }
}
