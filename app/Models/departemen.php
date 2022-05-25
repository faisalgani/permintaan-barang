<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class departemen extends Model
{

    use HasFactory;
	protected $keyType = 'string';
	public $incrementing = false;
	protected $table    = "departemen";
	protected $fillable = ['id','nama_departemen','updated_at', 'created_at'];

	
    
	
}
