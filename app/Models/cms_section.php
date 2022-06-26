<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class cms_section extends Model
{
    use HasFactory;

    protected $table = "cms_pages_section";

    protected $fillable = [
        'pageName', 'title', 'subtitle', 'sectionDesc', 'image', 'url',
    ];


    public $timestamps = false;

public function getImageAttribute($value)
{
    return unserialize($value);
   
}
}
