<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseDescriptionFeatures extends Model
{
    use HasFactory;

    protected $table = "CourseFeatures";

    protected $fillable = [
        'courseID', 'title', 'primeryList','secondaryList','Order',
    ];

    public $timestamps = false;


}
