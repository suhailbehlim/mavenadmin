<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Charge extends Model
{
    use HasFactory;

    protected $table = "charges";

    protected $fillable = [
        'boost_charge_for_customer', 
        'sponser_charge_for_customer', 
        'boost_charge_for_dealer',
        'sponser_charge_for_dealer',
    ];


    public $timestamps = false;


}
