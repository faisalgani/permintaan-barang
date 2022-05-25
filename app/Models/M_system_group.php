<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class M_system_group extends Model
{
    use HasFactory;
	protected $keyType = 'string';
	public $incrementing = false;
	protected $table    = "system_group";
	protected $fillable = ['id','group','active'];
}
