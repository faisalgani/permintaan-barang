<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class detailTransaksi extends Model
{
    use HasFactory;
	protected $keyType = 'string';
	public $incrementing = false;
	protected $table    = "detail_transaksi";
	protected $fillable = ['id_detail','no_transaksi','tgl_transaksi','id_barang','qty','keterangan','updated_at', 'created_at'];
}
