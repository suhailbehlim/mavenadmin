<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Banners extends Model
{
    use HasFactory;

    protected $table = "banners";

    protected $fillable = [
       'section','title', 'alt', 'desktop_banner', 'mobile_banner','description', 'status',
    ];


    public $timestamps = false;


}
