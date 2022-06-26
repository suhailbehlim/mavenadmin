<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Testomonial extends Model
{
    use HasFactory;

    protected $table = "testomonial";

    protected $fillable = [
        'name', 'type', 'category','image','description','video','status','url','review','photos','position','like','position'
    ];


    public $timestamps = false;


}
