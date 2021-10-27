<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    public function brand(){
        return $this->belongsTo(Brand::class);
    }
}
