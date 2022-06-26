<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Roles extends Model
{
    use HasFactory;

    protected $table = "roles";

    protected $fillable = [
        'name',
		'add',
		'edit',
		'delete',
		'view',
		'status',
		'created_at'
    ];


    public $timestamps = false;


}
