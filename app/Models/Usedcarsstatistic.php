<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Usedcarsstatistic extends Model
{
    use HasFactory;

    protected $table = "used_cars_statistics";

    protected $fillable = [
        'car_id',
		'new_make',
		'new_model',
		'new_year',
		'created_at'
    ];


    public $timestamps = false;


}
