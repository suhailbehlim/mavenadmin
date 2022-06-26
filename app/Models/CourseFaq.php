<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseFaq extends Model
{
    use HasFactory;

    protected $table = "CourseFaq";

    protected $fillable = [
        'courseID', 'question', 'answer','Order' 
    ];


    public $timestamps = false;


}
