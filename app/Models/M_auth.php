<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class M_auth extends Model
{
    use HasFactory;
	protected $keyType = 'string';
	public $incrementing = false;
	protected $table    = "auth";
	protected $fillable = [
        'id',
        'username',
        'password',
        'active',
        'last_login',
        'created_at',
        'updated_at',
    ];
}
