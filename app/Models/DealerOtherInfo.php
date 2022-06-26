<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DealerOtherInfo extends Model
{
    use HasFactory;

    protected $table = 'dealer_other_info';
    
    protected $fillable = [
        'dealer_id', 
        'company_name',
        'company_doc',
        'is_approved',
        'created_at',
        'updated_at'
    ];
}
