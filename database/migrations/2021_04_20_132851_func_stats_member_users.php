<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class FuncStatsMemberUsers extends Migration
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
            CREATE OR REPLACE FUNCTION public.getusermember(
                _id_user character varying,
                _id_group character varying)
                RETURNS integer
                LANGUAGE 'plpgsql'
                COST 100
            AS $$
            declare
            counter integer;
            begin
            select count(*) 
            into counter
            from system_member
            where id_user = _id_user and id_group = _id_group;
            
            return counter;
            end;
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
        DB::unprepared("DROP procedure IF EXISTS public.getusermember");
    }
}