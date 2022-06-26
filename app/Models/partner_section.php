<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class partner_section extends Model
{
    use HasFactory;

    protected $table = "partner_section";

    protected $fillable = [
        'image', 'sectionTitle', 'title', 'description','url'
    ];


    public $timestamps = false;


}
