<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Hash;

class DefaultData extends Migration
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
            INSERT INTO users (id, first_name, email) VALUES ('0', 'Super admin', 'admin@mail.com');
            UPDATE auth SET password='".Hash::make('%G8s2&')."' WHERE id='0';
            INSERT INTO system_group VALUES ('6a106a98-f83d-40d8-ac0b-f0e20ee7166f', 'User', true, '".date("Y-m-d H:i:s")."', '".date("Y-m-d H:i:s")."');
            INSERT INTO system_group VALUES ('d298295b-947a-417b-ad6b-740476096db0', 'Admin', true, '".date("Y-m-d H:i:s")."', '".date("Y-m-d H:i:s")."');
            INSERT INTO system_group VALUES ('e7dff575-b4ec-4c1c-8126-a6333dcabe6f', 'Super admin', true, '".date("Y-m-d H:i:s")."', '".date("Y-m-d H:i:s")."');
            INSERT INTO system_member (id, id_user, id_group, active) VALUES ('ef47664f9-67b1-48d6-b9af-970dfa7ad0b1', '0', 'e7dff575-b4ec-4c1c-8126-a6333dcabe6f', true);
            INSERT INTO system_menu (id, menu, link, active) VALUES ('c5d4c227-d981-4b7b-be00-14e16c835f4c', 'Users', '/admin/users', true);
            INSERT INTO system_menu (id, menu, link, active) VALUES ('ab99c793-5fa8-41e1-8f80-23baf51e903b', 'Group', '/admin/system_group', true);
            INSERT INTO system_menu (id, menu, link, active) VALUES ('31f2ed26-e3fb-4f6e-9e56-eecf095f9813', 'Member group', '/admin/system_member', true);
            INSERT INTO system_menu (id, menu, link, active) VALUES ('e0a64f34-f7d9-4430-8427-a856e74549b6', 'Menu', '/admin/system_menu', true);
            INSERT INTO system_menu (id, menu, link, active) VALUES ('7e6b6f83-e199-4963-88a2-31b271b6d09b', 'Member role', '/admin/system_role', true);
            INSERT INTO system_role (id, id_menu, id_group, active) VALUES ('0583a889-43ad-4cae-b024-bff0f827ed46', '31f2ed26-e3fb-4f6e-9e56-eecf095f9813', 'e7dff575-b4ec-4c1c-8126-a6333dcabe6f', true);
            INSERT INTO system_role (id, id_menu, id_group, active) VALUES ('19635e0a-5e78-4c43-9411-b677dd91fd08', '7e6b6f83-e199-4963-88a2-31b271b6d09b', 'e7dff575-b4ec-4c1c-8126-a6333dcabe6f', true);
            INSERT INTO system_role (id, id_menu, id_group, active) VALUES ('482d440b-7588-4642-91f4-b03449e25de0', 'ab99c793-5fa8-41e1-8f80-23baf51e903b', 'e7dff575-b4ec-4c1c-8126-a6333dcabe6f', true);
            INSERT INTO system_role (id, id_menu, id_group, active) VALUES ('50d79d81-c78a-4d8e-adf5-184e4e1e3a42', 'c5d4c227-d981-4b7b-be00-14e16c835f4c', 'e7dff575-b4ec-4c1c-8126-a6333dcabe6f', true);
            INSERT INTO system_role (id, id_menu, id_group, active) VALUES ('60464ed6-14a6-4fce-90d2-6f87ab3c2dc7', 'e0a64f34-f7d9-4430-8427-a856e74549b6', 'e7dff575-b4ec-4c1c-8126-a6333dcabe6f', true);
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
    }
}
