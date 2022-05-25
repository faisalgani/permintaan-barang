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

            INSERT INTO system_menu VALUES ('3dc52be4-a47e-4b21-ba62-3466589be2c6', 'Departemen', '/admin/departemen', 'fa fa-university', '', '', '', '1', 't', '2022-05-24 08:28:04', '2022-05-24 08:28:18');
            INSERT INTO system_menu VALUES ('877fb67a-5682-43ba-83e2-98c4704c6ce5', 'Customer', '/admin/customer', 'fa fa-users', '', '', '', '2', 't', '2022-05-24 08:21:25', '2022-05-24 08:28:18');
            INSERT INTO system_menu VALUES ('273c5e89-4471-4288-a8e7-8bb660b30b16', 'Barang', '/admin/barang', 'fa fa-barcode', '', '', '', '3', 't', '2022-05-24 08:20:35', '2022-05-24 08:28:19');
            INSERT INTO system_menu VALUES ('d8ddb16a-bfbb-4d8e-b2a7-69713ae0d074', 'Satuan Barang', '/admin/satuan_barang', 'fa fa-calculator', '', '', '', '4', 't', '2022-05-24 08:23:16', '2022-05-24 08:28:19');
            INSERT INTO system_menu VALUES ('fa122e86-e00a-4dd6-ba14-822aa6147a5b', 'Lokasi Barang', '/admin/lokasi_barang', 'fa fa-building', '', '', '', '5', 't', '2022-05-24 08:24:06', '2022-05-24 08:28:19');
            INSERT INTO system_menu VALUES ('8e7cdaa7-0d76-459c-811e-34d210705e9c', 'Permintaan Barang', '/admin/permintaan_barang', 'fa fa-address-card', '', '', '', '6', 't', '2022-05-24 08:25:00', '2022-05-24 08:28:19');
            INSERT INTO system_menu VALUES ('ee3f3ffe-0fd4-423f-b667-dc046533dc08', 'Setting', '#', 'fa fa-cogs', '', '', '', '7', 't', '2022-05-24 08:19:39', '2022-05-24 08:28:19');
            INSERT INTO system_menu VALUES ('c5d4c227-d981-4b7b-be00-14e16c835f4c', 'Users', '/admin/users', NULL, 'ee3f3ffe-0fd4-423f-b667-dc046533dc08', NULL, NULL, '7.1', 't', '2022-05-24 08:17:32', '2022-05-24 08:28:20');
            INSERT INTO system_menu VALUES ('ab99c793-5fa8-41e1-8f80-23baf51e903b', 'Group', '/admin/system_group', NULL, 'ee3f3ffe-0fd4-423f-b667-dc046533dc08', NULL, NULL, '7.2', 't', '2022-05-24 08:17:32', '2022-05-24 08:28:20');
            INSERT INTO system_menu VALUES ('31f2ed26-e3fb-4f6e-9e56-eecf095f9813', 'Member group', '/admin/system_member', NULL, 'ee3f3ffe-0fd4-423f-b667-dc046533dc08', NULL, NULL, '7.3', 't', '2022-05-24 08:17:32', '2022-05-24 08:28:20');
            INSERT INTO system_menu VALUES ('e0a64f34-f7d9-4430-8427-a856e74549b6', 'Menu', '/admin/system_menu', NULL, 'ee3f3ffe-0fd4-423f-b667-dc046533dc08', NULL, NULL, '7.4', 't', '2022-05-24 08:17:32', '2022-05-24 08:28:20');
            INSERT INTO system_menu VALUES ('7e6b6f83-e199-4963-88a2-31b271b6d09b', 'Member role', '/admin/system_role', NULL, 'ee3f3ffe-0fd4-423f-b667-dc046533dc08', NULL, NULL, '7.5', 't', '2022-05-24 08:17:32', '2022-05-24 08:28:20');
            
            INSERT INTO system_role VALUES ('605614e9-5e80-47bb-abde-c4e7a787604c', '3dc52be4-a47e-4b21-ba62-3466589be2c6', 'e7dff575-b4ec-4c1c-8126-a6333dcabe6f', 't', '2022-05-24 08:28:32', '2022-05-24 08:28:32');
            INSERT INTO system_role VALUES ('8f354527-a2b7-49e6-9f14-e5de3bc472cb', '877fb67a-5682-43ba-83e2-98c4704c6ce5', 'e7dff575-b4ec-4c1c-8126-a6333dcabe6f', 't', '2022-05-24 08:28:32', '2022-05-24 08:28:32');
            INSERT INTO system_role VALUES ('feb8bdf5-f4b0-49f2-a8bc-5ca70fe7cb68', '273c5e89-4471-4288-a8e7-8bb660b30b16', 'e7dff575-b4ec-4c1c-8126-a6333dcabe6f', 't', '2022-05-24 08:28:32', '2022-05-24 08:28:32');
            INSERT INTO system_role VALUES ('caa33c85-2783-443a-940a-c7050c74df1d', 'd8ddb16a-bfbb-4d8e-b2a7-69713ae0d074', 'e7dff575-b4ec-4c1c-8126-a6333dcabe6f', 't', '2022-05-24 08:28:33', '2022-05-24 08:28:33');
            INSERT INTO system_role VALUES ('0e66137b-c378-44b9-9151-21d7012cba60', 'fa122e86-e00a-4dd6-ba14-822aa6147a5b', 'e7dff575-b4ec-4c1c-8126-a6333dcabe6f', 't', '2022-05-24 08:28:33', '2022-05-24 08:28:33');
            INSERT INTO system_role VALUES ('ea236535-441a-448a-aab1-3640a71542c0', '8e7cdaa7-0d76-459c-811e-34d210705e9c', 'e7dff575-b4ec-4c1c-8126-a6333dcabe6f', 't', '2022-05-24 08:28:33', '2022-05-24 08:28:33');
            INSERT INTO system_role VALUES ('7ecb2119-5037-4ce1-9c7a-1f0befbd0446', 'ee3f3ffe-0fd4-423f-b667-dc046533dc08', 'e7dff575-b4ec-4c1c-8126-a6333dcabe6f', 't', '2022-05-24 08:28:33', '2022-05-24 08:28:33');
            INSERT INTO system_role VALUES ('cdb216ff-515a-4ebd-8c4a-3e9c22d535b6', 'c5d4c227-d981-4b7b-be00-14e16c835f4c', 'e7dff575-b4ec-4c1c-8126-a6333dcabe6f', 't', '2022-05-24 08:28:33', '2022-05-24 08:28:33');
            INSERT INTO system_role VALUES ('37d902a9-4b79-4c79-9843-be337d357613', 'ab99c793-5fa8-41e1-8f80-23baf51e903b', 'e7dff575-b4ec-4c1c-8126-a6333dcabe6f', 't', '2022-05-24 08:28:34', '2022-05-24 08:28:34');
            INSERT INTO system_role VALUES ('55cc1b02-a886-4b59-9754-5c08390e74b2', '31f2ed26-e3fb-4f6e-9e56-eecf095f9813', 'e7dff575-b4ec-4c1c-8126-a6333dcabe6f', 't', '2022-05-24 08:28:34', '2022-05-24 08:28:34');
            INSERT INTO system_role VALUES ('2d97e0a6-702a-44a2-8ef3-039fcbac9edc', 'e0a64f34-f7d9-4430-8427-a856e74549b6', 'e7dff575-b4ec-4c1c-8126-a6333dcabe6f', 't', '2022-05-24 08:28:34', '2022-05-24 08:28:34');
            INSERT INTO system_role VALUES ('12b77f2e-eeb8-4377-970d-7ef614ed9801', '7e6b6f83-e199-4963-88a2-31b271b6d09b', 'e7dff575-b4ec-4c1c-8126-a6333dcabe6f', 't', '2022-05-24 08:28:34', '2022-05-24 08:28:34');



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
