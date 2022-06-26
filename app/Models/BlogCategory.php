<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlogCategory extends Model
{
    use HasFactory;

    protected $table = "catblog";

    protected $fillable = [
        'slug', 'name', 'status', 'created_at', 'updated_at',
    ];


    public $timestamps = false;


}
