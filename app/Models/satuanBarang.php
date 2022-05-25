<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class satuanBarang extends Model
{
    use HasFactory;
	protected $keyType = 'string';
	public $incrementing = false;
	protected $table    = "satuan_barang";
	protected $fillable = ['id','satuan','updated_at', 'created_at'];
}
