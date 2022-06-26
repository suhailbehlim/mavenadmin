<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScholarshipScheme extends Model
{
    use HasFactory;

    protected $table = "ScholarshipScheme";

    protected $fillable = [
        'courseID', 'title', 'academic_criteria','test_score','scholarship', 'Order',
    ];

    public $timestamps = false;


}
