<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Usedcarsfuels extends Model
{
    use HasFactory;

    protected $table = "used_cars_fuels";

    protected $fillable = [
        'car_id',
		'engine_type',
		'fuel_type',
		'tank_capacity',
		'combine_mpg',
		'epa_mileage',
		'range',
		'created_at'
    ];


    public $timestamps = false;


}
