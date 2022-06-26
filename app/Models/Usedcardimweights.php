<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Usedcardimweights extends Model
{
    use HasFactory;

    protected $table = "used_cars_dimweight";

    protected $fillable = [
        'car_id',
		'body_type',
		'length',
		'width',
		'height',
		'wheelbase',
		'curb_weight',
		'created_at'
    ];


    public $timestamps = false;


}
