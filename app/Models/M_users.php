<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class M_users extends Model
{
    use HasFactory;
	protected $keyType = 'string';
	public $incrementing = false;
	protected $table    = "users";
	protected $fillable = ['id','first_name','last_name', 'email', 'phone', 'address','birthdate','gender', 'deleted_at'];
    
	function user_to_auth(){
		return $this->hasOne('App\Models\M_auth','id', 'id');
	}
}
