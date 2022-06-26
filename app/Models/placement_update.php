<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class placement_update extends Model
{
    use HasFactory;

    protected $table = "placement_update";

    protected $fillable = [
        'image', 'name', 'designation', 'company'
    ];


    public $timestamps = false;


}
