<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Usedcarsimages extends Model
{
    use HasFactory;

    protected $table = "used_cars_images";

    protected $fillable = [
        'car_id',
		'main_image',
		'year',
		'multiple_images',
		'creaetd_at'
    ];


    public $timestamps = false;


}
