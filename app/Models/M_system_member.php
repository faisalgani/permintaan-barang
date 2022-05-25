<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class M_system_member extends Model
{
    use HasFactory;
	protected $keyType = 'string';
	public $incrementing = false;
	protected $table    = "system_member";
	protected $fillable = ['id','id_user', 'id_group','active'];
}
