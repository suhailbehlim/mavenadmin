<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
//use App\Models\Usedcarsimages;

class Usedcars extends Model
{
    use HasFactory;

    protected $table = "used_cars";

    protected $fillable = [
        'name',
		'model',
		'year',
		'trim',
		'price',
		'user_id',
		'user_type',
		'created_at'
    ];


    public $timestamps = false;
    
    public function Usedcarsimages()
    {
        return $this->hasOne('App\Models\Usedcarsimages','car_id','id');
    }


}
