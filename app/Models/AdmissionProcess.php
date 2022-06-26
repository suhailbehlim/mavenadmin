<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdmissionProcess extends Model
{
    use HasFactory;

    protected $table = "AdmissionProcess";

    protected $fillable = [
        'courseID','type', 'title', 'description','image','Order',
    ];

    public $timestamps = false;


}
