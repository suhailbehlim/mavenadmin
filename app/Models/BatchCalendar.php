<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BatchCalendar extends Model
{
    use HasFactory;

    protected $table = "BatchCalendar";

    protected $fillable = [
        'courseID', 'mode', 'Date','Duration','Order',
    ];

    public $timestamps = false;


}
