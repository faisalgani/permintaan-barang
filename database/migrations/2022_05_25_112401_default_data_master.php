<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DefaultDataMaster extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $procedure = "
            INSERT INTO departemen VALUES (1, 'Departemen IT', '2022-05-24 09:37:29', '2022-05-24 09:37:29');
            INSERT INTO departemen VALUES (2, 'Departemen HR', '2022-05-24 09:39:56', '2022-05-24 09:39:56');
            INSERT INTO departemen VALUES (3, 'Departemen Keuangan', '2022-05-24 09:41:27', '2022-05-24 09:41:27');
            INSERT INTO departemen VALUES (4, 'Departemen Akuntansi', '2022-05-24 09:41:27', '2022-05-24 09:41:27');
            INSERT INTO departemen VALUES (5, 'Departemen Gudang', '2022-05-24 09:41:27', '2022-05-24 09:41:27');
            INSERT INTO departemen VALUES (6, 'Departemen Medis', '2022-05-24 09:41:27', '2022-05-24 09:41:27');
            INSERT INTO departemen VALUES (7, 'Departemen Produksi', '2022-05-24 09:41:27', '2022-05-24 09:41:27');
            INSERT INTO departemen VALUES (8, 'Departemen Departemen QA', '2022-05-24 09:41:27', '2022-05-24 09:41:27');
            INSERT INTO departemen VALUES (9, 'Departemen Sales', '2022-05-24 09:41:27', '2022-05-24 09:41:27');
            INSERT INTO departemen VALUES (10, 'Departemen Marketing', '2022-05-24 09:41:27', '2022-05-24 09:41:27');


            INSERT INTO lokasi_barang VALUES (1, 'Gedung A1', '2022-05-24 09:49:03', '2022-05-24 09:49:03');
            INSERT INTO lokasi_barang VALUES (2, 'Gudang Gedung D2', '2022-05-24 09:49:24', '2022-05-24 09:49:24');
            INSERT INTO lokasi_barang VALUES (3, 'Gedung C1', '2022-05-24 09:49:03', '2022-05-24 09:49:03');
            INSERT INTO lokasi_barang VALUES (4, 'Gudang D1', '2022-05-24 09:49:24', '2022-05-24 09:49:24');
            INSERT INTO lokasi_barang VALUES (5, 'Gedung D2', '2022-05-24 09:49:03', '2022-05-24 09:49:03');
            INSERT INTO lokasi_barang VALUES (6, 'Gudang Gedung A2 Lantai 1', '2022-05-24 09:49:24', '2022-05-24 09:49:24');
            INSERT INTO lokasi_barang VALUES (7, 'Gudang Gedung A2 Lantai 2', '2022-05-24 09:49:03', '2022-05-24 09:49:03');
            INSERT INTO lokasi_barang VALUES (8, 'Gedung C2', '2022-05-24 09:49:24', '2022-05-24 09:49:24');
            INSERT INTO lokasi_barang VALUES (9, 'Gedung Q11', '2022-05-24 09:49:03', '2022-05-24 09:49:03');
            INSERT INTO lokasi_barang VALUES (10, 'Gedung Q12', '2022-05-24 09:49:24', '2022-05-24 09:49:24');


            INSERT INTO satuan_barang VALUES (1, 'Unit', '2022-05-24 09:48:34', '2022-05-24 09:48:34');
            INSERT INTO satuan_barang VALUES (2, 'Lembar', '2022-05-24 09:48:45', '2022-05-24 09:48:45');
            INSERT INTO satuan_barang VALUES (3, 'Keping', '2022-05-24 09:48:34', '2022-05-24 09:48:34');
            INSERT INTO satuan_barang VALUES (4, 'Dus', '2022-05-24 09:48:45', '2022-05-24 09:48:45');
            INSERT INTO satuan_barang VALUES (5, 'Kaleng', '2022-05-24 09:48:34', '2022-05-24 09:48:34');
            INSERT INTO satuan_barang VALUES (6, 'RIM', '2022-05-24 09:48:45', '2022-05-24 09:48:45');
            INSERT INTO satuan_barang VALUES (7, 'Botol', '2022-05-24 09:48:34', '2022-05-24 09:48:34');
            INSERT INTO satuan_barang VALUES (8, 'Meter', '2022-05-24 09:48:45', '2022-05-24 09:48:45');
            INSERT INTO satuan_barang VALUES (9, 'Batang', '2022-05-24 09:48:34', '2022-05-24 09:48:34');
            INSERT INTO satuan_barang VALUES (10, 'Buah', '2022-05-24 09:48:45', '2022-05-24 09:48:45');



            INSERT INTO customer VALUES (1, 1, '33.201.578.000.1', 'Brams', '2022-05-24 10:42:43', '2022-05-24 10:42:43');
            INSERT INTO customer VALUES (2, 2, '31.220.590.000.1', 'Iwan', '2022-05-24 10:44:52', '2022-05-24 10:44:52');
            INSERT INTO customer VALUES (3, 3, '33.201.578.000.1', 'Gani', '2022-05-24 10:42:43', '2022-05-24 10:42:43');
            INSERT INTO customer VALUES (4, 4, '31.220.590.000.1', 'Faisal', '2022-05-24 10:44:52', '2022-05-24 10:44:52');
            INSERT INTO customer VALUES (5, 5, '33.201.578.000.1', 'Beni', '2022-05-24 10:42:43', '2022-05-24 10:42:43');
            INSERT INTO customer VALUES (6, 6, '31.220.590.000.1', 'Andre', '2022-05-24 10:44:52', '2022-05-24 10:44:52');
            INSERT INTO customer VALUES (7, 7, '33.201.578.000.1', 'Putri', '2022-05-24 10:42:43', '2022-05-24 10:42:43');
            INSERT INTO customer VALUES (8, 8, '31.220.590.000.1', 'Mawar', '2022-05-24 10:44:52', '2022-05-24 10:44:52');
            INSERT INTO customer VALUES (9, 9, '33.201.578.000.1', 'Dimas', '2022-05-24 10:42:43', '2022-05-24 10:42:43');
            INSERT INTO customer VALUES (10, 10, '31.220.590.000.1', 'Hendra', '2022-05-24 10:44:52', '2022-05-24 10:44:52');
            

            INSERT INTO barang VALUES (1, 'Susu UHT', 30, 1, 7, '2022-05-25 03:35:44', '2022-05-25 10:20:15');
            INSERT INTO barang VALUES (2, 'Air Mineral', 15, 1, 7, '2022-05-25 03:36:15', '2022-05-25 10:36:12');
            INSERT INTO barang VALUES (3, 'Kertas HVS', 68, 6, 6, '2022-05-25 03:35:44', '2022-05-25 10:20:15');
            INSERT INTO barang VALUES (4, 'ATK', 20, 3, 1, '2022-05-25 03:36:15', '2022-05-25 10:36:12');
            INSERT INTO barang VALUES (5, 'Laptop',12, 2, 1, '2022-05-25 03:35:44', '2022-05-25 10:20:15');
            INSERT INTO barang VALUES (6, 'Printer', 12, 2, 1, '2022-05-25 03:36:15', '2022-05-25 10:36:12');
            INSERT INTO barang VALUES (7, 'Perkakas',12, 10, 5, '2022-05-25 03:35:44', '2022-05-25 10:20:15');
            INSERT INTO barang VALUES (8, 'Keyboard', 10, 3, 1, '2022-05-25 03:36:15', '2022-05-25 10:36:12');
            INSERT INTO barang VALUES (9, 'Tangga',12, 2, 10, '2022-05-25 03:35:44', '2022-05-25 10:20:15');
            INSERT INTO barang VALUES (10, 'Mobil Dinas', 5, 9, 10, '2022-05-25 03:36:15', '2022-05-25 10:36:12');


            INSERT INTO transaksi VALUES (1, '0000001', '2022-05-25 00:00:00', 2, '2022-05-25 10:20:15', '2022-05-25 10:20:15');
            INSERT INTO transaksi VALUES (2, '0000002', '2022-05-25 00:00:00', 1, '2022-05-25 10:35:04', '2022-05-25 10:35:04');
            INSERT INTO transaksi VALUES (3, '0000003', '2022-05-25 00:00:00', 1, '2022-05-25 10:36:12', '2022-05-25 10:36:12');
            INSERT INTO transaksi VALUES (4, '0000004', '2022-05-25 00:00:00', 6, '2022-05-25 11:39:00', '2022-05-25 11:39:00');
            INSERT INTO transaksi VALUES (5, '0000005', '2022-05-25 00:00:00', 5, '2022-05-25 11:40:26', '2022-05-25 11:40:26');


            INSERT INTO detail_transaksi VALUES (1, '0000001', '2022-05-25 00:00:00', 2, 1, 'test 1', '2022-05-25 10:20:15', '2022-05-25 10:20:15');
            INSERT INTO detail_transaksi VALUES (2, '0000001', '2022-05-25 00:00:00', 1, 1, 'test 2', '2022-05-25 10:20:15', '2022-05-25 10:20:15');
            INSERT INTO detail_transaksi VALUES (3, '0000002', '2022-05-25 00:00:00', 2, 1, 'Test 3', '2022-05-25 10:35:04', '2022-05-25 10:35:04');
            INSERT INTO detail_transaksi VALUES (4, '0000003', '2022-05-25 00:00:00', 2, 1, 'test 4', '2022-05-25 10:36:12', '2022-05-25 10:36:12');
            INSERT INTO detail_transaksi VALUES (5, '0000004', '2022-05-25 00:00:00', 5, 1, 'Laptop 1', '2022-05-25 11:39:00', '2022-05-25 11:39:00');
            INSERT INTO detail_transaksi VALUES (6, '0000004', '2022-05-25 00:00:00', 5, 1, 'Keyboard 1', '2022-05-25 11:39:00', '2022-05-25 11:39:00');
            INSERT INTO detail_transaksi VALUES (7, '0000004', '2022-05-25 00:00:00', 6, 1, 'Printer 1', '2022-05-25 11:39:00', '2022-05-25 11:39:00');
            INSERT INTO detail_transaksi VALUES (8, '0000004', '2022-05-25 00:00:00', 9, 1, 'Tangga 1', '2022-05-25 11:39:00', '2022-05-25 11:39:00');
            INSERT INTO detail_transaksi VALUES (9, '0000005', '2022-05-25 00:00:00', 3, 2, 'HVS 2', '2022-05-25 11:40:26', '2022-05-25 11:40:26');
            INSERT INTO detail_transaksi VALUES (10, '0000005', '2022-05-25 00:00:00', 10, 1, 'Mobil 1', '2022-05-25 11:40:26', '2022-05-25 11:40:26');
            INSERT INTO detail_transaksi VALUES (11, '0000005', '2022-05-25 00:00:00', 5, 1, 'Laptop 1', '2022-05-25 11:40:26', '2022-05-25 11:40:26');
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
