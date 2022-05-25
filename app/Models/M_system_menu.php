<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class M_system_menu extends Model
{
    use HasFactory;
	protected $keyType = 'string';
	public $incrementing = false;
	protected $table    = "system_menu";
	protected $fillable = [
        'id',
        'menu',
        'link',
        'icon',
        'parent',
        'class',
        'active',
        'state',
        'order',
    ];
}
