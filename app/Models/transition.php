<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class transition extends Model
{
    protected $table = 'transition';
    protected $fillable = [
        'userID', 'packageID','payment_request_id','paymentTransitionID','paymentTransitionStatus', 'payment','address','note','offer'
    ];

    public function address(){
        return  $this->hasMany(address::class,'address','id');
    }
    public function order(){
        return  $this->hasMany(order::class,'transitionID','id')->with('package');
    }
    
    public function package(){
      return  $this->hasOne('\App\package','id','packageID')->with('service','area','location','propertype');
    }
}
