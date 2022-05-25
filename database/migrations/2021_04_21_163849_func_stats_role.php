<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class FuncStatsRole extends Migration
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
        CREATE OR REPLACE FUNCTION public.getgrouprole(
            _id_menu character varying,
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
        from system_role
        where id_menu = _id_menu and id_group = _id_group limit 1;
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
        DB::unprepared("DROP procedure IF EXISTS public.getgrouprole");
    }
}
