<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Usedcarsenginetrans extends Model
{
    use HasFactory;

    protected $table = "used_cars_enginetrans";

    protected $fillable = [
        'car_id',
		'cylinders',
		'engine_size',
		'hp',
		'hp_rpm',
		'torque',
		'torque_rpm',
		'drive_type',
		'transmission',
		'created_at'
    ];


    public $timestamps = false;


}
