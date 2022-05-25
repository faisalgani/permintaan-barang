<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class lokasiBarang extends Model
{
    use HasFactory;
	protected $keyType = 'string';
	public $incrementing = false;
	protected $table    = "lokasi_barang";
	protected $fillable = ['id','lokasi','updated_at', 'created_at'];
}
