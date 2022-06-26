<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Career extends Model
{
    use HasFactory;

    protected $table = "career";

    protected $fillable = [
        'title','opening', 'job', 'jobtype','location','description','status',
    ];


    public $timestamps = false;


}
