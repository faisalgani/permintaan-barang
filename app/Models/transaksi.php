<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class transaksi extends Model
{
    use HasFactory;
	protected $keyType = 'string';
	public $incrementing = false;
	protected $table    = "transaksi";
	protected $fillable = ['id','no_transaksi','tgl_transaksi','id_customer','updated_at', 'created_at'];

	function transaksi_to_detail(){
		return $this->hasMany('App\Models\detailTransaksi','no_transaksi', 'no_transaksi','tgl_transaksi','tgl_transaksi');
	}

	function transaksi_to_customer(){
		return $this->hasOne('App\Models\customer','id', 'id_customer');
	}
}
