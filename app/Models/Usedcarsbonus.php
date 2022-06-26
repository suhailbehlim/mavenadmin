<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Usedcarsbonus extends Model
{
    use HasFactory;

    protected $table = "used_cars_bonus";

    protected $fillable = [
        'car_id',
		'domestic_import',
		'origin_country',
		'car_classification',
		'platform_code',
		'date_added',
		'created_at'
    ];


    public $timestamps = false;


}
