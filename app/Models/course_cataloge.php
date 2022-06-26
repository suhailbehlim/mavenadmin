<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class course_cataloge extends Model
{
    use HasFactory;

    protected $table = "course_cataloge";

    protected $fillable = [
       'section','title', 'categories', 'image','description', 'status',
    ];


    public $timestamps = false;


}
