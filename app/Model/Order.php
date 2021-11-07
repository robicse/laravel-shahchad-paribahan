<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    public function vendor(){
        return $this->belongsTo(Vendor::class);
    }

    public function customer(){
        return $this->belongsTo(Customer::class);
    }

    public function vehicle(){
        return $this->belongsTo(Vehicle::class);
    }

    public function driver(){
        return $this->belongsTo(Driver::class);
    }
}