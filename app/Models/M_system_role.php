<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class M_system_role extends Model
{
    use HasFactory;
	protected $keyType = 'string';
	public $incrementing = false;
	protected $table    = "system_role";
	protected $fillable = [
        'id',
        'id_menu',
        'id_group',
        'active',
    ];
    
	function role_to_menu(){
		return $this->hasOne('App\Models\M_system_menu','id', 'id_menu');
	}
    
	function role_to_group(){
		return $this->hasOne('App\Models\M_system_group','id', 'id_group');
	}

}
