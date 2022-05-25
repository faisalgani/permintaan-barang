<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMSystemGroupsTable extends Migration
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
         * group varchar(15)
         * active bit
         * created_at datetime
         * updated_at datetime
         */
        if(!Schema::hasTable('system_group')){
            Schema::create('system_group', function (Blueprint $table) {
                $table->string('id');
                $table->primary('id');
                $table->string('group', 25);
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
        Schema::dropIfExists('system_group');
    }
}
