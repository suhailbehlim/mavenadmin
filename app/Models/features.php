<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class features extends Model
{
    use HasFactory;

    protected $table = "features";

    protected $fillable = [
        'image', 'name', 'description','section' 
    ];


    public $timestamps = false;


}
