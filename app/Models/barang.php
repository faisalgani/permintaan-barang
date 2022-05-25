<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class barang extends Model
{
    use HasFactory;
	protected $keyType = 'string';
	public $incrementing = false;
	protected $table    = "barang";
	protected $fillable = ['id','nama_barang','stok','id_lokasi','id_satuan','updated_at', 'created_at'];

    function barang_to_satuan(){
		return $this->hasOne('App\Models\satuanBarang','id', 'id_satuan');
	}

    function barang_to_lokasi(){
		return $this->hasOne('App\Models\lokasiBarang','id', 'id_lokasi');
	}

}
