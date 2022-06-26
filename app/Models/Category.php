<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $table = "categories";

    protected $fillable = [
        'slug', 'name', 'image', 'status', 'created_at', 'updated_at',
    ];


    public $timestamps = false;


}
