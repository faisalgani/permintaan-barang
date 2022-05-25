<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class customer extends Model
{
    use HasFactory;
	protected $keyType = 'string';
	public $incrementing = false;
	protected $table    = "customer";
	protected $fillable = ['id','id_departemen','nik','nama','updated_at', 'created_at'];

    function customer_to_departemen(){
		return $this->hasOne('App\Models\departemen','id', 'id_departemen');
	}
}
