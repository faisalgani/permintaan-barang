<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class FuncTriggerAutoAuth extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        $procedure = "
            CREATE FUNCTION public.create_default_auth()
                RETURNS trigger
                LANGUAGE 'plpgsql'
                COST 100
            AS $$
            BEGIN
            INSERT into auth (id, username, created_at, updated_at)
                VALUES (new.id, new.email, NOW(), NOW());
            return NEW;
            END
            $$;
        ";
        
        DB::unprepared($procedure);

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        DB::unprepared("DROP procedure IF EXISTS public.create_default_auth");
    }
}
