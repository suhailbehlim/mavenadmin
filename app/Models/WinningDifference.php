<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WinningDifference extends Model
{
    use HasFactory;

    protected $table = "WinningDifference";

    protected $fillable = [
        'courseID', 'title', 'icon','Order',
    ];

    public $timestamps = false;


}
