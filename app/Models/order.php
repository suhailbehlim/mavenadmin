<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class order extends Model
{
    protected $table = 'orders';
    protected $primaryKey = 'id';
    protected $fillable = [
        'transitionID',
        'packageID',
        'gift_option',

    ];
    public function transition(){
      return  $this->hasOne('\App\transition','id','transitionID');
    }

    public function package(){
        return  $this->hasOne('\App\package','id','packageID');
    }

}
