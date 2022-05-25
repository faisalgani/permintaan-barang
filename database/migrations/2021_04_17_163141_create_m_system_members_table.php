<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMSystemMembersTable extends Migration
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
         * id_user int(13)
         * id_group int(13)
         * active bit
         * created_at datetime
         * updated_at datetime
         */
        if(!Schema::hasTable('system_member')){
            Schema::create('system_member', function (Blueprint $table) {
                $table->string('id');
                $table->primary('id');
                $table->string('id_user');
                $table->foreign('id_user')->references('id')->on('users')
                ->onUpdate('cascade')
                ->onDelete('cascade');
                $table->string('id_group');
                $table->foreign('id_group')->references('id')->on('system_group')
                ->onUpdate('cascade')
                ->onDelete('cascade');
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
        Schema::dropIfExists('system_member');
    }
}
